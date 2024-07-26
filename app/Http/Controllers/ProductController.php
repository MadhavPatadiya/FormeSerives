<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //This method will show product page
    public function index()
    {

        $products = Product::orderBy('created_at', 'DESC')->get();
        return view('products.list', ['products' => $products]);

    }

    //This method will show create product
    public function create()
    {
        return view('products.create');
    }
    public function store(Request $request)
    {
        $rules = [

            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
        ];

        if ($request->image != "") {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();
        if ($request->image != "") {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $product->image = $imageName;
            $image->move(public_path('uploads/products'), $imageName);
            $product->save();

        }

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }
    public function edit()
    {

    }
    public function update()
    {

    }
    public function delete()
    {

    }
}
