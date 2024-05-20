<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $company_id = $request->input('company_id');

        $products = Product::query()
            ->when($search, function ($query, $search) {
                return $query->where('product_name', 'like', '%' . $search . '%');
            })
            ->when($company_id, function ($query, $company_id) {
                return $query->where('company_id', $company_id);
            })
            ->paginate(5);

        $companies = Company::all(); // 企業情報を取得

        return view('products.index', compact('products', 'companies'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
    
        $products = Product::where('product_name', 'like', '%' . $keyword . '%')->paginate(5);
    
        return view('products.index', compact('products'))->with('keyword', $keyword);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'product_name' => 'required|string|max:255',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable',
            'img_path' => 'nullable|image|max:2048',
        ]);

        $product = new Product([
            'product_name' => $request->get('product_name'),
            'company_id' => $request->get('company_id'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'comment' => $request->get('comment'),
        ]);

        if ($request->hasFile('img_path')) {
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        $product->save();

        return redirect()->route('products.create')->with('success', '登録されました。');
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
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        if ($request->hasFile('img_path')) {
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', '製品が更新されました。');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', '製品が削除されました。');
    }
}
