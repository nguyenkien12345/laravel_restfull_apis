<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
        ];
    }

    // Đối với API để trả về response của Form Request dưới dạng response json thay vì html thì ta phải ghi đè phương thức failedValidation
    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
            'errors' => $validator->errors(),
            'success' => false,
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'text' => 'failure',
            'time' => date("d/m/Y h:i:s"),
            'message' => 'Validation Failure',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
        throw (new ValidationException($validator, $response));
    }
}
