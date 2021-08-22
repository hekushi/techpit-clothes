<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function get(Request $request)
    {
        $id = $request->get('id');
        $product = Product::find($id);
        if (is_null($product)) {
            return [
                'error' => "$id is not exists."
            ];
        }

        $product->image = asset($product->image);
        $product->price = '¥' . number_format($product->price);
        $product->description = nl2br(e($product->description));

        return [
            'product' => $product,
        ];
    }
}
