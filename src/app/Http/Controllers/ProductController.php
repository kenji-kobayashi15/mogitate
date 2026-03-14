<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // 季節情報(seasons)も一緒に、6件ずつ取得
        $products = Product::with('seasons')->paginate(6);

        // views/products/index.blade.php を呼び出す
        return view('products.index', compact('products'));
    }
}
