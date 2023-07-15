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
        // get payment url from table payments and add it to products when there is no payment url in products table return null
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
        $api_key = base64_encode(env('XENDIT_SECRET_KEY'));
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . $api_key,
        ];

        $res = Http::withHeaders($headers)->post('https://api.xendit.co/v2/invoices', [
            'external_id' => $request['external_id'],
            'amount' => $request['amount'],
            'invoice_duration' => $request['invoice_duration'],
        ]);

        return json_decode($res->body(), true);
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
        $externalId = 'INV-' . date('Ymd') . '-' . rand(100, 999);

        $payment = $product->payments()->create([
            'external_id' => $externalId,
            'status' => 'pending',
            'amount' => $product->price
        ]);

        $params = [
            'external_id' => $externalId,
            'amount' => $product->price,
            'invoice_duration' => 3600,
        ];

        $invoice = $this->createInvoice($params);

        $payment->update([
            'payment_url' => $invoice['invoice_url'],
        ]);

        $product->update([
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }
}
