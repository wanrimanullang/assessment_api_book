<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Book;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_books()
    {
        $books = Book::factory(3)->create();
        $response = $this->get('/api/books');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_show_a_single_book()
    {
        $book = Book::factory()->create();
        $response = $this->get("/api/books/{$book->id}");
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['data' => $book->toArray()]);
    }

    /** @test */
    public function it_can_create_a_book()
    {
        $bookData = [
            'title' => 'New Book',
            'author' => 'New Author',
            'published_year' => 2023,
        ];

        $response = $this->post('/api/books', $bookData);
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['message' => 'Book created successfully']);

        $this->assertDatabaseHas('books', $bookData);
    }

    /** @test */
    public function it_can_update_a_book()
    {
        $book = Book::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'published_year' => 2022,
        ];

        $response = $this->put("/api/books/{$book->id}", $updatedData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Book updated successfully']);

        $this->assertDatabaseHas('books', array_merge(['id' => $book->id], $updatedData));
    }

    /** @test */
    public function it_can_delete_a_book()
    {
        $book = Book::factory()->create();
        $response = $this->delete("/api/books/{$book->id}");
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Book deleted successfully']);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
