<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product', function () {
    $query = request('query');
    if (empty($query)) {
        $products = \App\Models\Product::paginate(10);
    } else {
        $products = \App\Models\Product::search($query)->paginate(10);
    }
    $products->load('category:id,name as category_name'); // Eager load the category relationship

    if (request()->ajax()) {
        return response()->json([
            'products' => $products
        ]);
    }

    return view('search', compact('products'));
})->name('search');
