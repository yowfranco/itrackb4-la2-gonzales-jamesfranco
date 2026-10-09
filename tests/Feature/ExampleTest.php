<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_movies_page_returns_a_successful_response(): void
    {
        $response = $this->get('/movies');

        $response->assertStatus(200)
            ->assertSee('class="nav-link active"', false)
            ->assertSee('aria-current="page"', false);
    }

    public function test_movies_navigation_stays_active_on_detail_and_filtered_pages(): void
    {
        foreach (['/movies/1', '/movies?year=1994'] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('class="nav-link active"', false)
                ->assertSee('aria-current="page"', false);
        }
    }

    public function test_create_movie_form_has_all_fields_and_uses_named_post_route(): void
    {
        $this->get(route('movies.create'))
            ->assertOk()
            ->assertSee('method="POST"', false)
            ->assertSee('action="'.e(route('movies.store')).'"', false)
            ->assertSee('name="_token"', false)
            ->assertSee('name="id"', false)
            ->assertSee('name="title"', false)
            ->assertSee('name="year"', false)
            ->assertSee('<select', false)
            ->assertSee('name="genre"', false)
            ->assertSee('value="Action"', false)
            ->assertSee('value="Crime"', false)
            ->assertSee('value="Drama"', false)
            ->assertSee('name="is_available"', false)
            ->assertSee('>Yes</option>', false)
            ->assertSee('>No</option>', false)
            ->assertDontSee('Available</option>', false)
            ->assertDontSee('Not available</option>', false)
            ->assertSee('value="1"', false)
            ->assertSee('value="0"', false)
            ->assertDontSee('invalid-feedback', false)
            ->assertSee('value="1" selected', false)
            ->assertDontSee('value="99999"', false);
    }

    public function test_invalid_movie_form_shows_field_errors_and_retains_input_and_selection(): void
    {
        $this->from(route('movies.create'))
            ->post(route('movies.store'), [
                'id' => 99999,
                'title' => 'Remember This Title',
                'year' => '',
                'genre' => 'Drama',
                'is_available' => '1',
            ])
            ->assertRedirect(route('movies.create'))
            ->assertSessionHasErrors('year');

        $this->get(route('movies.create'))
            ->assertOk()
            ->assertSee('value="99999"', false)
            ->assertSee('value="Remember This Title"', false)
            ->assertSee('name="genre"', false)
            ->assertSee('value="Drama" selected', false)
            ->assertSee('value="1" selected', false)
            ->assertSee('id="year-error"', false)
            ->assertSee('The year field is required.');
    }

    public function test_stored_movie_appears_in_list_and_detail_page(): void
    {
        $moviesPath = storage_path('app/movies.json');
        $originalContents = file_get_contents($moviesPath);

        if ($originalContents === false) {
            $this->fail('Could not read the original movie data for the test.');
        }

        $id = 99999;

        try {
            $this->post(route('movies.store'), [
                'id' => $id,
                'title' => 'Test Movie',
                'year' => 2025,
                'genre' => 'Drama',
                'is_available' => '1',
            ])->assertRedirect(route('movies.show', $id))
                ->assertSessionHas('success', 'Movie added successfully.');

            $this->get(route('movies.show', $id))
                ->assertOk()
                ->assertSee('Movie added successfully.')
                ->assertSee('Test Movie')
                ->assertSee('2025')
                ->assertSee('Drama')
                ->assertSee('Availability:</strong> Yes', false);

            $this->get(route('movies.index'))
                ->assertOk()
                ->assertSee('Test Movie')
                ->assertDontSee('Movie added successfully.');

            $this->get(route('movies.show', $id))
                ->assertOk()
                ->assertDontSee('Movie added successfully.')
                ->assertSee('Test Movie')
                ->assertSee('2025')
                ->assertSee('Drama');

            $savedMovies = json_decode(file_get_contents($moviesPath), true, 512, JSON_THROW_ON_ERROR);
            $this->assertTrue($savedMovies[$id]['is_available']);
            $this->assertSame(1, count(array_filter(
                $savedMovies,
                fn (array $movie): bool => $movie['id'] === $id
            )));
        } finally {
            if (file_put_contents($moviesPath, $originalContents, LOCK_EX) === false) {
                throw new \RuntimeException('Could not restore movie data after the test.');
            }
        }
    }

    public function test_every_movie_record_has_availability_set_to_true(): void
    {
        $movies = json_decode(
            file_get_contents(storage_path('app/movies.json')),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        foreach ($movies as $movie) {
            $this->assertTrue($movie['is_available']);
        }
    }

    public function test_invalid_movie_submission_does_not_change_json_data(): void
    {
        $moviesPath = storage_path('app/movies.json');
        $originalContents = file_get_contents($moviesPath);

        if ($originalContents === false) {
            $this->fail('Could not read movie data for the validation test.');
        }

        $this->from(route('movies.create'))
            ->post(route('movies.store'), [])
            ->assertRedirect(route('movies.create'))
            ->assertSessionHasErrors(['id', 'title', 'year', 'genre', 'is_available']);

        $this->assertSame($originalContents, file_get_contents($moviesPath));
    }

    public function test_movie_genre_must_be_one_of_the_existing_genres(): void
    {
        $moviesPath = storage_path('app/movies.json');
        $originalContents = file_get_contents($moviesPath);

        if ($originalContents === false) {
            $this->fail('Could not read movie data for the validation test.');
        }

        $this->from(route('movies.create'))
            ->post(route('movies.store'), [
                'id' => 99999,
                'title' => 'Invalid Genre Movie',
                'year' => 2025,
                'genre' => 'Unknown',
                'is_available' => '1',
            ])
            ->assertRedirect(route('movies.create'))
            ->assertSessionHasErrors('genre');

        $this->assertSame($originalContents, file_get_contents($moviesPath));
    }

    public function test_movies_index_shows_all_movies_without_filters(): void
    {
        $response = $this->get('/movies');

        $response->assertSee('The Shawshank Redemption')
            ->assertSee('Availability')
            ->assertSee('Yes')
            ->assertSee('The Godfather')
            ->assertSee('The Dark Knight')
            ->assertSee('Pulp Fiction')
            ->assertSee('Forrest Gump')
            ->assertSee('Inception');
    }

    public function test_movies_index_filters_by_genre(): void
    {
        $response = $this->get('/movies?genre=Drama');

        $response->assertSee('The Shawshank Redemption')
            ->assertSee('Forrest Gump')
            ->assertDontSee('The Godfather')
            ->assertDontSee('The Dark Knight');
    }

    public function test_movies_index_filters_by_year(): void
    {
        $response = $this->get('/movies?year=1994');

        $response->assertSee('The Shawshank Redemption')
            ->assertSee('Pulp Fiction')
            ->assertSee('Forrest Gump')
            ->assertDontSee('The Godfather')
            ->assertDontSee('Inception');
    }

    public function test_movies_index_combines_genre_and_year_filters(): void
    {
        $response = $this->get('/movies?genre=Drama&year=1994');

        $response->assertSee('The Shawshank Redemption')
            ->assertSee('Forrest Gump')
            ->assertDontSee('Pulp Fiction')
            ->assertDontSee('The Godfather')
            ->assertDontSee('Inception');
    }

    public function test_movie_filter_links_preserve_the_other_active_filter(): void
    {
        $response = $this->get('/movies?genre=Drama&year=1994');

        $response->assertSee('href="'.e(route('movies.index', ['genre' => 'Action', 'year' => '1994'])).'"', false)
            ->assertSee('href="'.e(route('movies.index', ['genre' => 'Drama', 'year' => 2008])).'"', false)
            ->assertSee('Active filters:')
            ->assertSee('Genre: Drama')
            ->assertSee('Year: 1994')
            ->assertSee('href="'.e(route('movies.index')).'"', false)
            ->assertSee('Clear all filters');
    }

    public function test_movie_filter_links_are_available_without_active_filters(): void
    {
        $response = $this->get('/movies');

        $response->assertSee('None')
            ->assertSee('href="'.e(route('movies.index', ['genre' => 'Drama', 'year' => ''])).'"', false)
            ->assertSee('href="'.e(route('movies.index', ['genre' => '', 'year' => 1994])).'"', false);
    }

    public function test_old_movie_filter_url_redirects_to_query_string_filter(): void
    {
        $response = $this->get('/movies/filter/1994');

        $response->assertRedirect(route('movies.index', ['year' => 1994]));

        $this->followingRedirects()
            ->get('/movies/filter/1994')
            ->assertOk()
            ->assertSee('The Shawshank Redemption')
            ->assertDontSee('The Godfather')
            ->assertDontSee('Inception');
    }

    public function test_old_movie_filter_url_without_year_redirects_to_unfiltered_list(): void
    {
        $this->get('/movies/filter')
            ->assertRedirect(route('movies.index'));
    }

    public function test_movie_detail_page_shows_all_fields(): void
    {
        $response = $this->get('/movies/1');

        $response->assertStatus(200)
            ->assertSee('The Shawshank Redemption')
            ->assertSee('1994')
            ->assertSee('Drama')
            ->assertSee('James Franco A. Gonzales');
    }

    public function test_different_movie_ids_show_different_movies(): void
    {
        $firstMovie = $this->get('/movies/1');
        $secondMovie = $this->get('/movies/2');

        $firstMovie->assertSee('The Shawshank Redemption')
            ->assertDontSee('The Godfather');
        $secondMovie->assertSee('The Godfather')
            ->assertDontSee('The Shawshank Redemption');
    }

    public function test_unknown_movie_id_returns_a_clean_not_found_response(): void
    {
        $response = $this->get('/movies/999');

        $response->assertNotFound()
            ->assertDontSee('C:\\xampp\\htdocs');
    }
}
