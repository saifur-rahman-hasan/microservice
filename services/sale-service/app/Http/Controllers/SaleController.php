<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaleResource;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        return SaleResource::collection($sales);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'product' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        try {

            $sale = Sale::create([
                'user_id' => request('user_id'),
                'product' => request('product'),
                'quantity' => request('quantity'),
                'price' => request('price'),
                'amount' => request('amount')
            ]);

            return new SaleResource( $sale );

        }catch (\Exception $exception){
            return response()->json([
                'message' => 'Sorry! Unable to process your sale order',
                'errors' => [
                    'root' => $exception->getMessage()
                ]
            ], 500);
        }
    }
}
