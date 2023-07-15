<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('payments')->get();

        $products->map(function ($product) {
            $product->payment_url = $product->payments->count() > 0 ? $product->payments[0]->payment_url : null;
            return $product;
        });

        return Inertia::render('Product/Index', [
            'products' => $products,
        ]);
    }

    public function createInvoice($request)
    {
        // set api key and decode to base64

        // set headers

        // make request to xendit api

        // return response as decoded json
        return json_decode($res->body(), true);
    }

    public function createPayment($id)
    {
        // find product by id

        // check if already have pending payment

        // create external id

        // create to payment table

        // make request params

        // call create invoice function

        // update payment url

        // update product status

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function callback(Request $request)
    {
        try {
            // find payment by external id

            // check callback token

            // check if payment exist and update status

            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
