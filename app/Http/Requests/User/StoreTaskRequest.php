<?php

namespace App\Http\Requests\User;

use App\Http\Helpers\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class StoreTaskRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string',
            'description' => 'required|string',
            'status'      => 'required|' . Rule::in(['pending', 'in_progress', 'completed']),
            'due_date'    => 'required|date|date_format:d-m-Y|after_or_equal:today'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            Response::error($validator->errors()->all(),[],400)
        );
    }
}
