<?php

namespace App\Http\Requests;

use App\Enums\UserRoleEnum;
use App\Models\Offer;
use App\Models\Project;
use App\Rules\NotOffensive;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class StoreOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = Auth::user();
        $projectId = $this->route('project_id') ?? $this->input('project_id');

        // 1. التحقق من نوع المستخدم
        if (!$user || $user->role !== UserRoleEnum::FREELANCER) {
            return $this->failAuth('not_freelancer');
        }

        // 2. التحقق من وجود المشروع
        $project = Project::find($projectId);
        if (!$project) {
            return $this->failAuth('project_not_found');
        }

        // 3. منع صاحب المشروع
        if ($project->client_id === $user->id) {
            return $this->failAuth('own_project');
        }

        // 4. التحقق من حالة المشروع
        if ($project->status !== 'open') {
            return $this->failAuth('project_closed');
        }

        // 5. منع تكرار العرض
        $exists = Offer::where('project_id', $projectId)
            ->where('freelancer_id', $user->id)
            ->exists();

        if ($exists) {
            return $this->failAuth('already_submitted');
        }

        return true;
    }

    /**
     * إرجاع استجابة JSON موحدة عند فشل الصلاحية
     */
    protected function failAuth(string $reason): bool
    {
        $messages = [
            'not_freelancer' => 'عذراً، فقط المستقلين (Freelancers) يمكنهم تقديم عروض.',
            'project_not_found' => 'المشروع غير موجود.',
            'own_project' => 'لا يمكنك تقديم عرض على مشروعك الخاص.',
            'project_closed' => 'هذا المشروع لم يعد يقبل عروضاً جديدة.',
            'already_submitted' => 'لقد قدمت عرضاً على هذا المشروع من قبل.',
        ];

        $message = $messages[$reason] ?? 'ليس لديك صلاحية تنفيذ هذا الإجراء.';

        // ✅ للـ API: نرمي استثناء يعيد JSON بدلاً من redirect
        throw new HttpResponseException(
            response()->json(['errors' => ['auth' => $message]], 403)
        );
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('cover_letter')) {
            $this->merge([
                'cover_letter' => trim($this->string('cover_letter')),
            ]);
        }
    }

    public function rules(): array
    {
        $projectId = $this->route('project_id') ?? $this->input('project_id');
        $project = Project::find($projectId);
        $isFixed = $project?->budget_type === 'fixed';

        return [
            'project_id' => ['required', 'integer', 'exists:projects,id'],

            'cover_letter' => [
                'required', 'string', 'min:50', 'max:2000',
                new NotOffensive(),
            ],

            'delivery_time' => [
                'required', 'integer', 'min:1', 'max:365',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) use ($isFixed, $project) {
                    if (!$project) return;

                    if ($isFixed) {
                        if ($value > $project->budget_amount * 2) {
                            $fail('عرضك مرتفع جداً مقارنة بميزانية المشروع.');
                        }
                    } else {
                        if ($value < 5 || $value > 500) {
                            $fail('السعر الساعي يجب أن يكون بين 5 و 500.');
                        }
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.exists' => 'المشروع المحدد غير موجود.',
            'cover_letter.min' => 'يجب أن يتكون خطاب التقديم من 50 حرفاً على الأقل.',
            'price.min' => 'يجب أن يكون السعر أكبر من صفر.',
            'delivery_time.min' => 'مدة التسليم يجب أن تكون يوماً واحداً على الأقل.',
        ];
    }
}
