<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Transactions;

class TransactionsController extends BaseController
{
    public function index()
    {
        $products = Products::all();
        return view('transactions.index', ['products' => $products]);
    }

    public function store(Request $request)
    {
        $transaction = Transactions::create([
            'receipt_number' => $request->input('receipt_number'),
            'transaction_date' => \Carbon\Carbon::createFromFormat('d/m/y, H.i.s', $request->input('transaction_date'))->format('Y-m-d H:i:s'),
            'total_price' => $request->input('total_price'),
            'created_by' => auth()->id(),
        ]);

        foreach ($request->input('items') as $product) {
            $transaction->details()->create([
                'product_id' => $product['product_id'],
                'qty' => $product['qty'],
                'unit_price' => $product['unit_price'],
                'subtotal' => $product['qty'] * $product['unit_price'],
            ]);
        }

        foreach ($request->input('items') as $product) {
            $productModel = Products::find($product['product_id']);
            if ($productModel) {
                $productModel->stock -= $product['qty'];
                $productModel->save();
            }
        }

        return response()->json(['status' => true]);
    }
}
