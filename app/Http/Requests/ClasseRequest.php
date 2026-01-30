<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClasseRequest extends FormRequest
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
            'nom' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'annee_scolaire_id' => 'required|exists,annee_scolaires,id',
            'frais_scolaire_id' => 'required|exists,frais_scolaires,id',
        ];
    }
}
