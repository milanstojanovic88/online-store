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

    	for( $i = 0; $i < 20; $i++) {
		    $product = new Product([
			    'name' => 'Sample movie Number ' . (string)($i+1),
			    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aspernatur consequatur cum distinctio, dolorum eum eveniet nobis non, nostrum odio odit omnis similique sit soluta suscipit, ullam voluptas. Repellendus, temporibus!',
			    'price' => 12.50,
			    'image_path' => 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcRRl8bHiO1v8nLyAKfHXEr8cE1nho_EfvLbZ6ELG1q6SJgrniWq',
			    'category_id' => '1'
		    ]);

		    $product->save();
	    }


    }
}
