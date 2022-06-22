<?php

namespace Tests\Feature;

use App\Models\Auction;
use App\Models\Book;
use App\Models\User;
use Database\Seeders\BookSeeder;
use Database\Seeders\BooksWithCategoriesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(302);

        $response = $this->get('/login');
        $response->assertSeeText(['BookApp', 'Login', 'Email Address', 'Password']);
        $response->assertSee(['app.css']);
        $response->assertSee(['app.js']);
        $response->assertSee(['button']);
    }

    public function testIfRenderRegisterForm()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSeeText(['Confirm Password', 'Register', 'Email Address', 'Password']);
    }

    public function testIfReturnBooks()
    {
        $this->seed([
            BookSeeder::class
        ]);

        $response = $this->getJson('/books-list');
        $response->assertSeeText(['books', 'meta', 'links']);
        $response->assertJsonPath('links.first',  "http://book-app.test/books-list?page=1");
        $response->assertJsonPath('links.last',  "http://book-app.test/books-list?page=1");
        $response->assertJsonPath('books.0.name', "Book First");
        $response->assertJsonPath('books.1.name', "Book Second");
        $response->assertJsonPath('meta.total', 2);
    }

    public function testNameFilter()
    {
        $this->seed([
            BookSeeder::class
        ]);

        $response = $this->getJson('/books-list?name=Book Firs');
        $response->assertJsonPath('books.0.name', 'Book First');
        $response->assertJsonPath('meta.total', 1);
    }

    public function testCategoryNameFilter()
    {
        $this->seed([
            BookSeeder::class,
            BooksWithCategoriesSeeder::class,
        ]);

        $response = $this->getJson('/books-list?category_name=Another cate');
        $response->assertJsonPath('books.0.name', 'Book Second from BooksWithCategoriesSeeder');
        $response->assertJsonPath('meta.total', 1);

        $response = $this->getJson('/books-list?category_name=Category name');
        $response->assertJsonPath('books.0.name', 'Book First');
        $response->assertJsonPath('meta.total', 2);
    }

    public function testIfLoadAuth()
    {
        $this->seed([
            BookSeeder::class,
            BooksWithCategoriesSeeder::class,
        ]);

        $user = User::factory()->create(['settings' => []]);

        $response = $this
            ->actingAs($user)
            ->get('/admin/category');

        $response->assertStatus(200);
        $response->assertSeeText(['Category Name', 'Another category']);
    }

    public function testAuthJson()
    {
        // 1. pasikurima vartotoja
        // 2. sukuriam jam token
        // 3. perduodam ta pati token per header

        $user = User::factory()->create(['settings' => []]);
        $token = $user->createToken('login')->plainTextToken;

        $response = $this->getJson(
            '/api/auctions',
            [
                'Authorization' => 'Bearer ' . $token
            ]
        );

        $response->assertStatus(200);
        $response->assertJson(['data' => []]);
    }

    public function testAuctionCreate()
    {
        //1. auth vartotoja
        // 2. paduodam auction data
        // 3. Patikrinam duomenu baze

        $this->seed([
            BookSeeder::class
        ]);
        $books = Book::all();

        $user = User::factory()->create(['settings' => []]);
        $token = $user->createToken('login')->plainTextToken;

        $response = $this->postJson(
            '/api/auctions',
            [
                'book_id' => $books[0]->id,
                'price' => 400,
                'enabled' => true,
                'quantity' => 3
            ],
            [
                'Authorization' => 'Bearer ' . $token
            ]
        );

        $response->assertStatus(201);
        $response->assertJson(json_decode('{"data":{"id":1,"name":"Book First","price":4,"currency":"EUR","quantity":3}}', true));

        $auctions = Auction::all();
        $this->assertCount(1, $auctions);
        $this->assertEquals($auctions[0]->price, 400);
        $this->assertEquals($auctions[0]->quantity, 3);
    }
}
