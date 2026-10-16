<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        if (!$product->is_active) abort(404);

        $related = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('client.products.show', compact('product', 'related'));
    }

    public function compare(Request $request)
    {
        $ids = collect(explode(',', $request->input('ids', '')))
            ->filter()
            ->map(fn($v) => (int) $v)
            ->unique()
            ->take(4);

        $products = Product::whereIn('id', $ids)->where('is_active', true)->get();
        $allProducts = Product::where('is_active', true)->get();

        return view('client.products.compare', compact('products', 'allProducts'));
    }
}
