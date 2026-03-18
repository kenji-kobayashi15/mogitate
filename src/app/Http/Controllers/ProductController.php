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
            // 'asc' なら低い順、'desc' なら高い順に並び替える
            $query->orderBy('price', $request->sort);
        } else {
            // 何も選ばれていなければ、新着順（IDの大きい順）にしておく
            $query->orderBy('id', 'desc');
        }

        // 季節情報(seasons)も一緒に、6件ずつ取得
        $products = $query->with('seasons')->paginate(6)->withQueryString();

        // views/products/index.blade.php を呼び出す
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        // IDをもとに商品1件を取得（季節情報もセットで）
        $product = Product::with('seasons')->findOrFail($id);

        // products/show.blade.php にデータを渡す
        return view('products.show', compact('product'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->validated());

        $product->seasons()->sync($request->seasons);

        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // 商品を削除（関連する中間テーブルのデータもsync([])で消しておくと丁寧です）
        $product->seasons()->detach();
        $product->delete();

        return redirect()->route('products.index');
    }

    public function create()
    {
        // 登録画面を表示するだけ
        return view('products.create');
    }

    public function store(ProductRequest $request) // ここで ProductRequest を使う！
    {
        // 画像がアップロードされているか確認しつつ保存
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 2. データベースへの登録（商品本体）
        $product = Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $imagePath, // 保存したパスを記録
        ]);

        // 中間テーブルへの保存（ここで送られてきた [1, 2] などの数字が使われます）
        if ($request->seasons) {
            $product->seasons()->attach($request->seasons);
        }

        // 4. 一覧画面へ戻る
        return redirect()->route('products.index');
    }
}
