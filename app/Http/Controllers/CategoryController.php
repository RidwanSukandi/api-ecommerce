<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryRequestUpdate;
use App\Models\category;
use App\Models\product;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function create(CategoryRequest $request)
    {
        $validate = $request->validated();

        if (category::where('nm_category', $validate['nm_category'])->count() === 1) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        "category allready exist"
                    ]
                ]

            ]));
        }

        $category = new category($validate);

        $category->save();

        return response()->json([
            'data' => [
                'id' => $category->id,
                'nm_category' => $category->nm_category
            ]
        ], 201);
    }


    public function get()
    {
        // $categories = category::orderByAsc('nm_category')->get();
        $categories = category::orderBy('nm_category')->get();

        $data = [];

        foreach ($categories as $category) {

            $data[] = [
                'id' => $category->id,
                'nm_category' => $category->nm_category
            ];
        }

        return response()->json([
            'data' => [
                $data
            ]
        ], 200);
    }

    function update(CategoryRequestUpdate $request, string $id)
    {

        $validate = $request->validated();

        if (category::where('id', $id)->get()->isEmpty()) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        "data not found"
                    ]
                ]

            ]));
        }

        if (category::where('nm_category', $validate['nm_category'])->count() === 1) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        "category allready exist"
                    ]
                ]

            ]));
        }

        category::find($id)->update($validate);

        return response()->json([
            'message' => [
                'Success'
            ]
        ], 200);
    }

    function destroy(string $id)
    {
        if (category::where('id', $id)->get()->isEmpty()) {
            throw new HttpResponseException(response([
                'errors' => [
                    'message' => [
                        "data not found"
                    ]
                ]

            ]));
        }

        category::find($id)->delete();

        return response()->json([
            'message' => [
                'Success'
            ]
        ], 200);
    }
}
