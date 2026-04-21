<?php

namespace App\Http\Requests;

use App\Models\Offer;
use App\Models\Project;
use App\Rules\NotOffensive;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreOfferRequest extends FormRequest
{
    protected ?string $failedAuthorizationReason = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         $user = Auth::user();
        $projectId = $this->route('store-offer') ?? $this->input('project_id');

        if (!$user || $user->role !== 'freelancer') {
            $this->failedAuthorizationReason = 'not_freelancer';
            return false;
        }

        $project = Project::findOrFail($projectId);
        if (!$project) {
            $this->failedAuthorizationReason = 'project_not_found';
            return false;
        }
          if ($project->client_id === $user->id) {
            $this->failedAuthorizationReason = 'own_project';
            return false;
        }
          if ($project->status !== 'open') {
            $this->failedAuthorizationReason = 'project_closed';
            return false;
        }
         $alreadySubmitted = Offer::where('project_id', $projectId)
            ->where('freelancer_id', $user->id)
            ->exists();

        if ($alreadySubmitted) {
            $this->failedAuthorizationReason = 'already_submitted';
            return false;
        }
             $this->failedAuthorizationReason = null;
        return true;

    }


 protected function failedAuthorization()
    {
        $messages = [
            'not_freelancer' => 'عذراً، فقط المستقلين (Freelancers) يمكنهم تقديم عروض.',
            'project_not_found' => 'المشروع غير موجود.',
            'own_project' => 'لا يمكنك تقديم عرض على مشروعك الخاص.',
            'project_closed' => 'هذا المشروع لم يعد يقبل عروضاً جديدة.',
            'already_submitted' => 'لقد قدمت عرضاً على هذا المشروع من قبل.',
        ];

        $reason = $this->failedAuthorizationReason ?? 'unauthorized';
        $message = $messages[$reason] ?? 'ليس لديك صلاحية تنفيذ هذا الإجراء.';

        // إعادة التوجيه مع الرسالة (يمكن تغييرها لـ JSON إذا كنت تبني API)
        redirect()->back()->withErrors(['auth' => $message])->withInput();
    }


   protected function prepareForValidation(): void
    {
        // تنظيف خطاب التقديم من المسافات الزائدة
        $this->merge([
            'cover_letter' => trim($this->cover_letter),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         $project = Project::findOrFail($this->route('project') ?? $this->input('project_id'));
        $isFixed = $project->budget_type === 'fixed';


        return [
            'project_id' => ['required','exists:projects,id'],

              'cover_letter' => [ 'required',  'string',  'min:100',  'max:2000',  new NotOffensive(), ],
             'delivery_time' => [ 'required', 'integer', 'min:1', 'max:365' ],
             'status' => [ 'required', 'in:pending,accepted,rejected'],
             'price' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($isFixed, $project) {
                    if ($isFixed) {
                        // للميزانية الثابتة: السعر يجب أن يكون ضمن نطاق معقول
                        if ($value > $project->budget_amount * 2) {
                            $fail('عرضك مرتفع جداً مقارنة بميزانية المشروع.');
                        }
                    } else {
                        // للساعي: السعر يجب أن يكون معقولاً للساعة
                        if ($value < 5 || $value > 500) {
                            $fail('السعر الساعي يجب أن يكون بين 5 و 500.');
                        }
                    }
                },
            ],        ];
    }
}
