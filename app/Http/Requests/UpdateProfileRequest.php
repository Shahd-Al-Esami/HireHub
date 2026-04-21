<?php

namespace App\Http\Requests;

use App\Enums\AvailabilityStatusEnum;
use App\Models\Profile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $profile = $this->route('profile');
        //   $profile = Profile::find($profileId);
        return $profile && $profile->user_id === $this->user()->id;
    }

    /**
     * Prepare data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('portfolio_links') && is_string($this->portfolio_links)) {
            $this->merge([
                'portfolio_links' => json_decode($this->portfolio_links, true)
            ]);
        }

        if ($this->has('skills_summary') && is_string($this->skills_summary)) {
            $this->merge([
                'skills_summary' => json_decode($this->skills_summary, true)
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'bio' => ['nullable', 'string', 'max:1000'],

            'hourly_rate' => ['nullable', 'numeric', 'min:0', 'max:999999.9999'],

            'image' => ['nullable', 'url', 'max:255'],

            'phone_number' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/'
            ],

            'portfolio_links' => ['nullable', 'array', 'max:10'],
            'portfolio_links.*' => ['url', 'max:255'],

            'skills_summary' => ['nullable', 'array', 'max:50'],
            'skills_summary.*' => ['string', 'max:100'],

            'availability_status' => [
                'nullable',
                Rule::in(AvailabilityStatusEnum::getValues())
            ],
        ];
    }


    public function messages(): array
    {
        return [
            'hourly_rate.numeric' => 'سعر الساعة يجب أن يكون رقماً.',
            'phone_number.regex' => 'صيغة رقم الهاتف غير صحيحة.',
            'portfolio_links.*.url' => 'جميع روابط المعرض يجب أن تكون روابط صحيحة.',
            'availability_status.in' => 'قيمة حالة التوفر غير صحيحة.',
        ];
    }
}
