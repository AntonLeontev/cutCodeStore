<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Src\Domains\Catalog\ViewModels\BrandViewModel;
use Src\Domains\Catalog\ViewModels\CategoryViewModel;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = CategoryViewModel::make()->homePage();

        $products = Product::whereOnHome(1)->get();

        $brands = BrandViewModel::make()->homePage();

        return view('home', compact('categories', 'products', 'brands'));
    }
}
