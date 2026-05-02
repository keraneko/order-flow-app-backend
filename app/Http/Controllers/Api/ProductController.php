<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateProductSalesStatusRequest;

class ProductController extends Controller
{
    public function index()
    {
        return Product::select('id', 'name', 'price','is_active', 'is_visible', 'image_path')->orderby('id')->get();
    }

    public function store(StoreProductRequest $request)
    {
        $user = $request->user();
        if(! $user->can('create',Product::class)){
            abort(403);
        }

        $data = $request->validated();
        if($request->hasFile('image')){
            $path = $request->file('image')->store('products','public');
            $data['image_path'] = $path; 
        }
        $product = Product::create($data);
        $product_api = Product::select('id', 'name', 'price','is_active', 'is_visible', 'image_path')
         ->where('id',$product->id)->first();
        return $product_api;
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $user = $request->user();
        if(! $user->can('update',$product)){
            abort(403);
        }

        $data = $request->validated();
        if($request->hasFile('image')){
            $path = $request->file('image')->store('products','public');
            $data['image_path'] = $path; 
        }
        $product->update($data);
        $product_api = Product::select('id', 'name', 'price','is_active', 'is_visible', 'image_path')
         ->where('id',$product->id)->first();

        return $product_api;
    }

    public function updateSalesStatus(UpdateProductSalesStatusRequest $request, Product $product)
    {
        $user = $request->user();
        if(! $user->can('update',$product)){
            abort(403);
        }

        $validated = $request->validated();
        $product->update($validated);

        $productStatus = Product::select('id','is_active')
         ->where('id',$product->id)->first();


        return $productStatus;

    }


}
