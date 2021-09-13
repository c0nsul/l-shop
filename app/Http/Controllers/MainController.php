<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class MainController extends Controller
{
    private $pageLimit = 6;

    /**
     * @param ProductsFilterRequest $request
     * @param Product $productModel
     * @return Application|Factory|View
     */
    public function index(ProductsFilterRequest $request,Product $productModel)
    {
        $productsQuery = $productModel::query();

        if ($request->filled('price_from')) {
            $productsQuery->where('price', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $productsQuery->where('price', '<=', $request->price_to);
        }

        foreach (['hit', 'new', 'recommend'] as $field) {
            if ($request->has($field)) {
                $productsQuery->where($field, 1);
            }
        }

        //pagination influence: changing page should not reset filter (->withPath("?" . $request->getQueryString());)
        $products = $productsQuery->paginate($this->pageLimit)->withPath("?" . $request->getQueryString());

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
