<?php

namespace Tests\Feature;

use App\Models\Auction;
use App\Models\User;
use Database\Seeders\BookSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
//    public function test_the_application_returns_a_successful_response()
//    {
//        $response = $this->get('/login');
//
//        $response->assertStatus(200);
//        $this->assertStringContainsString("BookApp", $response->getContent());
////        dump($response);
//    }

    /**
     * A basic test example.
     *
     * @return void
     */
//    public function testBookListEndpoint()
//    {
//        $this->seed(BookSeeder::class);
//        $response = $this->get('/books-list');
//
//        var_dump($response->content());
//        $response->assertStatus(200);
//        $response->assertJson(["links" => ["first" => "http://book-app.test/books-list?page=1"]]);
//        $response->assertJsonPath('books.0.name', 'Book name');
//        $response->assertJsonPath('books.1.name', 'Book name 2');
//        $response->assertJson(fn(AssertableJson $json) =>
//        $json
//            ->has('books', 2)
//            ->has('books.0',
//                fn($json) => $json
//                    ->where('name', 'Book name')
//                    ->etc()
//            )->etc()
//        );
////        dump($response);
//    }

    /**
     * A basic test example.
     * @group failing
     *
     * @return void
     */
//    public function testApi()
//    {
//        $user = User::factory()->create();
//        $token = $user->createToken('login')->plainTextToken;
//        $response = $this->get('/api/auctions', ['Authorization' => 'Bearer ' . $token]);
//
//        var_dump($response->content());
//        $response->assertStatus(200);
//        $response->assertJson(["links" => ["first" => "http://book-app.test/books-list?page=1"]]);
//        $response->assertJsonPath('books.0.name', 'Book name');
//        $response->assertJsonPath('books.1.name', 'Book name 2');
//        $response->assertJson(fn(AssertableJson $json) =>
//        $json
//            ->has('books', 2)
//            ->has('books.0',
//                fn($json) => $json
//                    ->where('name', 'Book name')
//                    ->etc()
//            )->etc()
//        );
////        dump($response);
//    }

    /**
     * A basic test example.
     * @group failing
     *
     * @return void
     */
    public function testApiPost()
    {
        $this->seed(BookSeeder::class);
        $user = User::factory()->create();
        $token = $user->createToken('login')->plainTextToken;

        $response = $this->postJson(
            '/api/auctions',
            [
                'book_id' => 1,
                'price' => 44,
                'enabled' => true,
                'quantity' => 12,
            ],
            ['Authorization' => 'Bearer ' . $token]
        );

        var_export($response->getContent());
        var_export(Auction::all());
        $response->assertStatus(200);
        $response->assertJson(["links" => ["first" => "http://book-app.test/books-list?page=1"]]);
        $response->assertJsonPath('books.0.name', 'Book name');
        $response->assertJsonPath('books.1.name', 'Book name 2');
        $response->assertJson(fn(AssertableJson $json) =>
        $json
            ->has('books', 2)
            ->has('books.0',
                fn($json) => $json
                    ->where('name', 'Book name')
                    ->etc()
            )->etc()
        );
//        dump($response);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStuff()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/admin/author');

        dd('??');

        $this->seed(BookSeeder::class);
        $response = $this->get('/books-list');

        var_dump($response->content());
        $response->assertStatus(200);
        $response->assertJson(["links" => ["first" => "http://book-app.test/books-list?page=1"]]);
        $response->assertJsonPath('books.0.name', 'Book name');
        $response->assertJsonPath('books.1.name', 'Book name 2');
        $response->assertJson(fn(AssertableJson $json) =>
        $json
            ->has('books', 2)
            ->has('books.0',
                fn($json) => $json
                    ->where('name', 'Book name')
                    ->etc()
            )->etc()
        );
//        dump($response);
    }
}
