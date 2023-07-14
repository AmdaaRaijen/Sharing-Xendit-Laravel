<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {

        $products = Product::with('payments')->get();

        return Inertia::render('Product/Index', [
            'products' => $products

        ]);
    }
}
