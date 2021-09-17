<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


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
        $productsQuery = $productModel::with('Category');

        if ($request->filled('price_from')) {
            $productsQuery->where('price', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $productsQuery->where('price', '<=', $request->price_to);
        }

        foreach (['hit', 'new', 'recommend'] as $field) {
            if ($request->has($field)) {
                $productsQuery->$field;
            }
        }

        //pagination influence: changing page should not reset filter
        // (->withPath("?" . $request->getQueryString());)
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
     * @param Product $productModel
     * @param $productCode
     * @return Application|Factory|View
     */
    public function product($category, Product $productModel, $productCode) {
        $product = $productModel::withTrashed()->byCode($productCode)->firstOrFail();
        return view('product', compact('product'));
    }

}
