<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new Product([
	        'name' => 'Fast and Furious',
	        'description' => 'Movie description...',
	        'price' => 20.00,
	        'image_path' => 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcRRl8bHiO1v8nLyAKfHXEr8cE1nho_EfvLbZ6ELG1q6SJgrniWq',
	        'category_id' => '1'
        ]);

	    $product->save();

	    $product = new Product([
		    'name' => 'Star Trek',
		    'description' => 'Movie description...',
		    'price' => 18.99,
		    'image_path' => 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcRRl8bHiO1v8nLyAKfHXEr8cE1nho_EfvLbZ6ELG1q6SJgrniWq',
		    'category_id' => '1'
	    ]);

	    $product->save();

	    $product = new Product([
		    'name' => 'World of Warcraft',
		    'description' => 'Game description...',
		    'price' => 44.55,
		    'image_path' => 'http://letiarts.com/letiarts2014/wp-content/uploads/2014/04/icon_game.png',
		    'category_id' => '2'
	    ]);

	    $product->save();

	    $product = new Product([
		    'name' => 'Mass Effect 3',
		    'description' => 'Game description...',
		    'price' => 44.55,
		    'image_path' => 'http://letiarts.com/letiarts2014/wp-content/uploads/2014/04/icon_game.png',
		    'category_id' => '2'
	    ]);

	    $product->save();

	    $product = new Product([
		    'name' => 'Counter-Strike: GO',
		    'description' => 'Game description...',
		    'price' => 24.99,
		    'image_path' => 'http://letiarts.com/letiarts2014/wp-content/uploads/2014/04/icon_game.png',
		    'category_id' => '2'
	    ]);

	    $product->save();
    }
}
