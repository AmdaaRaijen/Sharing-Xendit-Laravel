<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return Inertia::render('Product/Index', [
            'products' => $products,
        ]);
    }

    public function createPayment($id)
    {
        $product = Product::find($id);
        $isAlreadyExist = Payment::where('product_id', $id)
            ->where('status', 'pending')
            ->exists();

        if ($isAlreadyExist) {
            return response()->json([
                'status' => 'error',
                'message' => 'You already have a pending payment for this product'
            ], 400);
        }

        $externalId = 'INV-' . $product->id . '-' . time();

        $product->payments()->create([
            'external_id' => $externalId,
            'status' => 'pending',
            'amount' => $product->price
        ]);

        $product->update([
            'status' => 'pending'
        ]);


        return response()->json([
            'status' => 'success',
        ]);
    }
}
