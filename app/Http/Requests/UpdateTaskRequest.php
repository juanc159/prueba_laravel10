<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'El campo id es obligatorio',
            'title.required' => 'El campo title es obligatorio',
            'description.required' => 'El campo description es obligatorio',
            'status.required' => 'El campo status es obligatorio',
            'status.enum' => 'El campo status no es válido.',
            'due_date.required' => 'El campo due_date es obligatorio',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code' => 422,
            'message' => 'Se evidencia algunos errores',
            'errors' => $validator->errors(),
        ], 422));
    }
}
