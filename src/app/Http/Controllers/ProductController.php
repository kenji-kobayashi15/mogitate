<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->filled('sort')) {
            $query->orderBy('price', $request->sort);
        } else {
            $query->orderBy('id', 'desc');
        }

        $products = $query->with('seasons')->paginate(6)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function show($productId)
    {
        $product = Product::with('seasons')->findOrFail($productId);

        return view('products.show', compact('product'));
    }

    public function update(ProductRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // $product->name = $request->name;
        // $product->price = $request->price;
        // $product->description = $request->description;

        // if ($request->hasFile('image')) {
        //     if ($product->image) {
        //         Storage::disk('public')->delete($product->image);
        //     }

        //     $imagePath = $request->file('image')->store('products', 'public');
        //     $product->image = $imagePath;
        // }
        // $product->save();
        // $product->seasons()->sync($request->seasons);
        // return redirect()->route('products.index');
        // }


        // リファクタリングした表示方法
        // fill + saveをupdateで一行に
        $product->update($request->only(['name', 'price', 'description']));

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image);
            $product->update(['image' => $request->file('image')->store('products', 'public')]);
        }

        $product->seasons()->sync($request->seasons);

        return redirect()->route('products.index');
    }

    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->seasons()->detach();
        $product->delete();

        return redirect()->route('products.index');
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    // {
    //     バリデーションでimage必須にしているので、必ずここを通ります
    //     $imagePath = $request->file('image')->store('products', 'public');

    //     $product = Product::create([
    //         'name'        => $request->name,
    //         'price'       => $request->price,
    //         'description' => $request->description,
    //         'image'       => $imagePath,
    //     ]);
    //     if ($request->seasons) {
    //         $product->seasons()->attach($request->seasons);
    //     }
    //     return redirect()->route('products.index');
    // }

    // リファクタリングしたコード
    {
        $product = Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $request->file('image')->store('products', 'public'),
        ]);

        // if不要
        $product->seasons()->attach($request->seasons);

        return redirect()->route('products.index');
    }

}
