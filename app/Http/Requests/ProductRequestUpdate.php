<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use function Laravel\Prompts\error;

class ProductRequestUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|max:100",
            "price" => "required",
            "description" => "nullable",
            "category" => "required",
            "image" => "required|image|mimes:jpeg,png,jpg,gif|max:255",
            "rate" => "required",
            "count" => "required",
        ];
    }


    function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            'errors' => [
                'message' => [
                    $validator->getMessageBag()
                ]
            ]
        ], 400));
    }
}
