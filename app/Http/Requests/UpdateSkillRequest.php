<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSkillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $profile = $this->route('profile');
       // If profile is an ID (string), fetch the model
        if (is_numeric($profile) || is_string($profile)) {
            $profile = \App\Models\Profile::find($profile);
        }

        return $profile && Auth::id() === $profile->user_id;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
  'skills'                       => ['required', 'array', 'min:1'],
            // distinct prevents sending the same skill ID twice in one request.
            'skills.*.id'                  => ['required', 'numeric', 'distinct', 'exists:skills,id'],
            // 'skills.*.experience_years'    => ['required', 'integer', 'min:0', 'max:50'],
                    'experience_years'=> 'sometimes|numeric|min:0|max:50',
        ];
    }
}
