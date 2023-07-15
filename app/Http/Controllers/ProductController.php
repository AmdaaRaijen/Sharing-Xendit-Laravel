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

    public function createPayment($id)
    {
        $product = Product::find($id);

        $externalId = 'INV-' . $product->id . '-' . time();

        $product->payments()->create([
            'external_id' => $externalId,
            'status' => 'pending',
            'amount' => $product->price
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }
}
