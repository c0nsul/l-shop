<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class MainController extends Controller
{
    private $pageLimit = 6;

    /**
     * @param $locale
     * @return RedirectResponse
     */
    public function changeLocale($locale): RedirectResponse
    {
        $availableLocales = ['ru', 'en'];
        if (!in_array($locale, $availableLocales)) {
            $locale = config('app.locale');
        }
        session(['locale' => $locale]);
        App::setLocale($locale);
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function subscribe(SubscriptionRequest $request, Product $product): RedirectResponse
    {
        Subscription::create([
            'email' => $request->email,
            'product_id' => $product->id,
        ]);

        return redirect()->back()->with('success', 'Thank you, we will let you know when the item arrives.');
    }


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
