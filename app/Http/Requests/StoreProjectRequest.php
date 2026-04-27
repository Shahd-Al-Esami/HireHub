<?php

namespace App\Http\Requests;

use App\Rules\NotOffensive;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Enums\UserRoleEnum;
class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize(): bool
    {
        $user = Auth::user();

        if (!$user) {
            $this->throwApi(401, 'يجب تسجيل الدخول أولاً.');
        }

        if ($user->role !== UserRoleEnum::CLIENT) {
            $this->throwApi(403, 'غير مصرح: هذا الإجراء مخصص للعملاء (Clients) فقط.');
        }

        return true;
          }

    protected function throwApi(int $status, string $message): void
    {
        throw new HttpResponseException(
            response()->json(['message' => $message], $status)
        );
    }



       protected function prepareForValidation(): void
    {
        // 1. Normalize tags: convert comma-separated string to array & trim whitespace
        if ($this->filled('tags') && is_string($this->tags)) {
            $this->merge([
                'tags' => array_map('trim', explode(',', $this->tags)),
            ]);
        }

    //     // 2. Set default status (users shouldn't control initial status)
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
            'client_id' => ['exists:users,id'],
          'title' => [
            'required', 'string', 'min:10', 'max:150',
            new NotOffensive(),
        ],

            'description' => [
            'required', 'string', 'min:50', 'max:5000',
            new NotOffensive(),
        ],

          'budget_type' => ['required', 'string', Rule::in(['fixed', 'hourly'])],
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

              'delivery_date' => ['required', 'date', 'after:today'],
              'status' => ['sometimes','in:open,in_progress,closed'],


             'tags' => ['nullable', 'array', 'max:5'],
            'tags.*' => ['integer','exists:tags,id','distinct'],
        ];
    }



       public function messages(): array
    {
        return [
            // Required field messages
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'budget_type.required' => 'The budget type field is required.',
            'budget_amount.required' => 'The budget amount field is required.',
            'delivery_date.required' => 'The delivery date field is required.',

            // Validation messages
            'delivery_date.after' => 'The delivery date must be a future date.',
            'tags.max' => 'You can attach a maximum of 5 tags.',
            'title.min' => 'The project title must be at least 10 characters to be clear.',
            'title.max' => 'The project title must not exceed 150 characters.',
            'description.min' => 'Please provide a more detailed description so freelancers can submit accurate proposals.',
            'description.max' => 'The description must not exceed 5000 characters.',
            'budget_type.in' => 'The budget type must be either fixed or hourly.',
            'budget_amount.numeric' => 'The budget amount must be a number.',
            'budget_amount.min' => 'The budget amount must be a positive value.',
            'delivery_date.date' => 'The delivery date must be a valid date.',
            'status.in' => 'The status must be one of: open, in_progress, closed.',
            'tags.array' => 'Tags must be an array.',
            'tags.*.string' => 'Each tag must be a string.',
            'tags.*.max' => 'Each tag must not exceed 30 characters.',
        ];
    }
}
