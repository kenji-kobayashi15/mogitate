<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

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

    public function show($id)
    {
        $product = Product::with('seasons')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        $product->seasons()->sync($request->seasons);

        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->seasons()->detach();
        $product->delete();

        return redirect()->route('products.index');
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        if ($request->seasons) {
            $product->seasons()->attach($request->seasons);
        }

        return redirect()->route('products.index');
    }
}
