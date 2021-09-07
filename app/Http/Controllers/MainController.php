<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class MainController extends Controller
{
    public function index(Product $productModel)
    {
        $products = $productModel::get();
        return view("index", compact('products'));
    }

    public function categories(Category $categoryModel)
    {
        $categories = $categoryModel->get();
        return view('categories', compact('categories'));
    }

    public function category($category, Category $categoryModel)
    {
        $category = $categoryModel::where("code", $category)->first();
        return view('category', compact('category'));
    }

    public function product($category,$product = null, Category $categoryModel)
    {
        $category = $categoryModel::where("code", $category)->first();
        return view("product", compact('product', 'category'));
    }

}
