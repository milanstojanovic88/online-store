<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function getCategoryImage($filename)
    {
        $file = Storage::disk('local')->get($filename);

	    return new Response($file, 200);
    }

    public function getCategoryPage($category_name)
    {
    	$products = Product::where(
    		'category_id',
		    '=',
		    Category::where('category_name', '=', $category_name)->first()->id
	    )->paginate(16);

        return view('store.' . $category_name)->with('products', $products);
    }
}
