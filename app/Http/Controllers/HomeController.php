<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::whereOnHome(1)->get();

        $products = Product::whereOnHome(1)->get();

        $brands = Brand::whereOnHome(1)->get();

        return view('home', compact('categories', 'products', 'brands'));
    }
}
