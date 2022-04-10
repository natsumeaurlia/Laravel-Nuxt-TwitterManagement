<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskType;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $accounts = $this->user()->accounts()->pluck('id');
        $sleepTime = Task::MAX_SLEEP_TIME;
        return [
            'account_id' => ['required', Rule::in($accounts->toArray())],
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(TaskType::getValues())],
            'execution_interval' => 'required|integer|max:1440|min:1|multiple_of:5',
            'is_enable' => 'required|boolean',
            'keyword' => 'nullable|string|max:3000',
            'start_time_period' => 'required|date_format:H:i',
            'end_time_period' => 'required|date_format:H:i|after:start_time_period',
            'max_execution' => 'required|integer|max:100',
            'range_min_sleep_time' => "required|integer|max:${sleepTime}",
            'range_max_sleep_time' => "required|integer|gte:range_min_sleep_time|max:${sleepTime}",
        ];
    }
}
