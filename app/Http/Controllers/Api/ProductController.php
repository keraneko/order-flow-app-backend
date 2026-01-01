<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    Public function index()
    {
        return Product::select('id', 'name', 'price')->orderby('id')->get();
    }
}
