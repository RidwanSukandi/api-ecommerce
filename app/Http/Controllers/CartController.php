<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class CartController extends Controller
{
    public function create(CartRequest $request)
    {
        $validate = $request->validated();

        $product = new Cart($validate);
        $product->userId = Auth::user()->id;
        $product->date = now();
        $product->save();

        return response()->json([
            'data' => [
                'id' => $product->id,
                'userId' => $product->userId,
                'date' => $product->date,
                'products' =>  [
                    'productId' => $product->productId,
                    'quantity' => $product->quantity,
                ]
            ]

        ]);
    }
}
