<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class taskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        //mettre a true pour dire que l'utilisateur et authentifier sinon par defaut c'est false
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
            //
            //verification des champs por la creation
             'breakdown' => ['required'],
             'location' => ['required'],
             'start_date' => ['required', 'date','after_or_equal:today'],
             'due_date' => ['nullable', 'date', 'after:start_date'],
             'description' => ['required'],

             //verification des champs por le update plus certain champs du haut
             'name' => ['required'],
             'place' => ['required'],
        ];
    }
}
