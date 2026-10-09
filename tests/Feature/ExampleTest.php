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

    public function test_movies_index_shows_all_movies_without_filters(): void
    {
        $response = $this->get('/movies');

        $response->assertSee('The Shawshank Redemption')
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
