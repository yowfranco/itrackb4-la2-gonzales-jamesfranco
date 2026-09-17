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

        $response->assertStatus(200);
    }

    public function test_movie_filter_page_uses_the_filtered_results_view(): void
    {
        $response = $this->get('/movies/filter');

        $response->assertStatus(200)
            ->assertSee('Movies from 1994')
            ->assertSee('The Shawshank Redemption')
            ->assertDontSee('The Godfather');
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
