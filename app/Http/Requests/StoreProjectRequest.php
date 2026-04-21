<?php

namespace App\Http\Requests;

use App\Rules\NotOffensive;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         return Auth::check() && Auth::user()->role=== 'client';
    }





       protected function prepareForValidation(): void
    {
        // 1. Normalize tags: convert comma-separated string to array & trim whitespace
        if ($this->filled('tags') && is_string($this->tags)) {
            $this->merge([
                'tags' => array_map('trim', explode(',', $this->tags)),
            ]);
        }

        // 2. Set default status (users shouldn't control initial status)
        $this->merge([
            'status' => 'open',
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */


    public function rules(): array
    {
          $isFixed  = $this->input('budget_type') === 'fixed';
        $isHourly = $this->input('budget_type') === 'hourly';

         return [
            'client_id' => ['required','exists:users,id'],
          'title' => [
            'required', 'string', 'min:10', 'max:150',
            new NotOffensive(),
        ],

            'description' => [
                'required', 'string', 'min:50', 'max:5000',
                new NotOffensive(),
            ],

          'budget_type' => ['required', Rule::in(['fixed', 'hourly'])],

            'budget_amount' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($isFixed, $isHourly) {
                    if ($isFixed && $value < 100) {
                        $fail('Fixed budget must be at least 100.');
                    }
                    if ($isHourly && $value < 5) {
                        $fail('Hourly rate must be at least 5.');
                    }
                },
            ],

              'deadline' => ['required', 'date', 'after:today'],
              'status' => ['required','in:open,in_progress,closed'],


             'tags' => ['nullable', 'array', 'max:5'],
            'tags.*' => ['string', 'max:30'],
        ];
    }



       public function messages(): array
    {
        return [
            'deadline.after' => 'The delivery deadline must be a future date.',
            'tags.max' => 'You can attach a maximum of 5 tags.',
            'title.min' => 'The project title must be at least 10 characters to be clear.',
            'description.min' => 'Please provide a more detailed description so freelancers can submit accurate proposals.',
        ];
    }
}
