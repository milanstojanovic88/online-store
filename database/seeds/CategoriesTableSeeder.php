<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
        $category = new Category([
            'category_name' => 'movies',
	        'image_name' => 'movies_category.png',
	        'description' => 'Category description...'
        ]);

	    $category->save();

		$category = new Category([
			'category_name' => 'games',
			'image_name' => 'games_category.png',
			'description' => 'Category description...'
		]);

		$category->save();

	    $category = new Category([
		    'category_name' => 'books',
		    'image_name' => 'books_category.png',
		    'description' => 'Category description...'
	    ]);

	    $category->save();

	    $category = new Category([
		    'category_name' => 'music',
		    'image_name' => 'music_category.png',
		    'description' => 'Category description...'
	    ]);

	    $category->save();
	}
}
