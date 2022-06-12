<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        $category = new Category();
        $category->name = 'Category Name';
        $category->active = true;
        $category->save();

        Book::factory()->create([
            'name' => 'Book First',
            'category_id' => $category->id
        ]);

        Book::factory()->create([
            'name' => 'Book Second',
            'category_id' => $category->id
        ]);
    }
}
