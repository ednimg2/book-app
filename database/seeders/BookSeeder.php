<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $category = new Category();
        $category->name = 'TestCategory';
        $category->active = 1;
        $category->save();

        Book::factory()->create([
            'name' => 'Book name',
            'description' => 'Description',
            'category_id' => $category->id,
            'iban' => 'Iban',
            'year' => '2020',
            'pages' => '1000',
            'format' => 'pdf',
            'language' => 'en',
            'sku' => 'sku1'
        ]);

        Book::factory()->create([
            'name' => 'Book name 2',
            'description' => 'Description 2',
            'iban' => 'Iban',
            'category_id' => $category->id,
            'year' => '2020',
            'pages' => '1000',
            'format' => 'pdf',
            'language' => 'en',
            'sku' => 'sku2'
        ]);
    }
}
