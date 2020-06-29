<?php

namespace App\Http\Controllers;

use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::all();
        return PurchaseResource::collection($purchases);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'amount' => 'required|numeric'
        ]);

        try {

            $purchase = Purchase::create([
                'user_id' => request('auth_id'),
                'product' => request('product'),
                'quantity' => request('quantity'),
                'price' => request('price'),
                'amount' => request('amount'),
            ]);

            return new PurchaseResource( $purchase );

        }catch (\Exception $exception){
            return response()->json([
                'message' => "Unable to create purchase order.",
                'errors' => [
                    'root' => $exception->getMessage()
                ]
            ], 500);
        }
    }
}
