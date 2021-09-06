<?php

namespace App\Http\Controllers;

use App\Models\Category;

class MainController extends Controller
{
    public function index()
    {
        return view("index");
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

    public function basket() {
        return view('basket');
    }

    public function basketPlace() {
        return view('order');
    }
}