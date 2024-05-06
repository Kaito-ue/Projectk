<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Validatorクラスをインポート

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        $products = Product::paginate(4);

        if ($request->has('search') && !empty($request->search)) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('manufacturer') && !empty($request->manufacturer)) {
            $query->where('company_id', $request->manufacturer);
        }

        $products = $query->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|integer',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = new Product();
        $product->product_name = $request->input('product_name');
        $product->company_id = $request->input('company_id');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->comment = $request->input('comment');

        if ($request->hasFile('img_path')) {
            $imagePath = $request->file('img_path')->store('products', 'public');
            $product->img_path = '/storage/' . $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', '商品が登録されました。');
    }

    public function show(Product $product)
    {
        return view('products.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product->product_name = $request->input('product_name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->comment = $request->input('comment');

        if ($request->hasFile('img_path')) {
            $imagePath = $request->file('img_path')->store('products', 'public');
            $product->img_path = '/storage/' . $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', '商品が更新されました。');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/products')->with('success', '商品が削除されました。');
    }
}
