<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BooksWithCategoriesSeeder extends Seeder
{
    public function run()
    {
        $category = new Category();
        $category->name = 'With category Name';
        $category->active = true;
        $category->save();

        $category2 = new Category();
        $category2->name = 'Another category';
        $category2->active = true;
        $category2->save();

        Book::factory()->create([
            'name' => 'Book First',
            'category_id' => $category->id
        ]);

        Book::factory()->create([
            'name' => 'Book Second from BooksWithCategoriesSeeder',
            'category_id' => $category2->id
        ]);
    }
}
