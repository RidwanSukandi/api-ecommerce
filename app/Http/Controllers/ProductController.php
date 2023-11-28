<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductRequestUpdate;
use App\Models\product;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create(ProductRequest $request)
    {
        $validate = $request->validated();

        if (product::where('title', $validate['title'])->count() === 1) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        "product allready exist"
                    ]
                ]

            ]));
        }

        $product = new product($validate);
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        $imageUrl = url('api/images/' . $imageName);
        $product->image = $imageUrl;
        $product->save();

        return response()->json([
            'data' => [
                'id' => $product->id_product,
                'title' => $product->title,
                'price' => $product->price,
                'description' => $product->description,
                'category' => $product->category,
                'rating' => [
                    'rate' => $product->rate,
                    'count' => $product->count,
                ]
            ]
        ], 200);
    }

    function get(Request $request)
    {

        $limit = $request->input('limit');
        $sort = $request->input('sort');

        if ($limit) {
            return  $products = product::limit($limit)->get();
        } elseif ($sort) {
            return  $products = product::orderBy('title', $sort)->get();
        }

        $formattedProducts = [];

        $products = Product::all();

        foreach ($products as $product) {
            $formattedProducts[] =
                [
                    'id' => $product->id_product,
                    'title' => $product->title,
                    'price' => $product->price,
                    'description' => $product->description,
                    'category' => $product->category,
                    'rating' => [
                        'rate' => $product->rate,
                        'count' => $product->count,
                    ]
                ];
        }

        return response()->json([
            'data' => $formattedProducts
        ], 200);
    }

    public function getId(string $id)
    {

        if (product::where('id_product', $id)->count() !== 1) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        "data not found"
                    ]
                ]

            ]));
        }

        $product = product::find($id);

        return response()->json([
            'data' => [
                'id' => $product->id_product,
                'title' => $product->title,
                'price' => $product->price,
                'description' => $product->description,
                'category' => $product->category,
                'rating' => [
                    'rate' => $product->rate,
                    'count' => $product->count,
                ]
            ]
        ], 200);
    }

    public function getInCategory(string $category)
    {
        $product = Product::where('category', $category)->first();

        if (!$product) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        "data not found"
                    ]
                ]

            ]));
        }

        return response()->json([
            'data' => [
                'id' => $product->id_product,
                'title' => $product->title,
                'price' => $product->price,
                'description' => $product->description,
                'category' => $product->category,
                'rating' => [
                    'rate' => $product->rate,
                    'count' => $product->count,
                ]
            ]
        ], 200);
    }

    function update(ProductRequestUpdate $request, string $id)
    {

        $validate = $request->validated();

        if (product::where('id_product', $id)->count() !== 1) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        "data not found"
                    ]
                ]

            ]));
        }

        $product = Product::whre('id_product', $id)->update($validate);
    }


    public function delete($id)
    {
        if (product::where('id_product', $id)->count() !== 1) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        "data not found"
                    ]
                ]

            ]));
        }

        Product::where('id_product', $id)->delete();

        return response()->json([
            'message' => [
                'Success'
            ]
        ], 200);
    }
}
