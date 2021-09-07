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

    public function category($category, Category $categoryModel, Product $productModel)
    {
        $category = $categoryModel::where("code", $category)->first();
        $products = $productModel::where("category_id", $category->id)->get();
        return view('category', compact('category', 'products'));
    }

    public function product($category,$product = null, Category $categoryModel)
    {
        $category = $categoryModel::where("code", $category)->first();
        return view("product", compact('product', 'category'));
    }

    public function basket() {
        return view('basket');
    }

    public function basketPlace() {
        return view('order');
    }
}
