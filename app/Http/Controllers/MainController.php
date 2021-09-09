<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{
    /**
     * @param Product $productModel
     * @return Application|Factory|View
     */
    public function index(Product $productModel)
    {
        $products = $productModel::get();
        return view("index", compact('products'));
    }

    /**
     * @param Category $categoryModel
     * @return Application|Factory|View
     */
    public function categories(Category $categoryModel)
    {
        $categories = $categoryModel->get();
        return view('categories', compact('categories'));
    }

    /**
     * @param $category
     * @param Category $categoryModel
     * @return Application|Factory|View
     */
    public function category($category, Category $categoryModel)
    {
        $category = $categoryModel::where("code", $category)->first();
        return view('category', compact('category'));
    }

    /**
     * @param $category
     * @param $productCode
     * @param Product $productModel
     * @param Category $categoryModel
     * @return Application|Factory|View
     */
    public function product($category,$productCode, Product $productModel, Category $categoryModel)
    {
        $product = $productModel::where("code", $productCode)->first();
        $category = $categoryModel::where("code", $category)->first();
        return view("product", compact('product', 'category'));
    }

}
