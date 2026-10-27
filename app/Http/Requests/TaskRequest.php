<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'task_id' => 'required|integer|exists:tasks,task_id',
            'project' => 'required|integer|exists:projects,project_id',
            'name' => 'required|string',
            'priority' => 'nullable|integer',
            'status' => 'required|in:open,in-progress,completed',
        ];
    }
}
