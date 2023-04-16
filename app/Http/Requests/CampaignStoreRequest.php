<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'         => 'required',
            'subject'      => 'required',
            'content'      => 'required',
            'from_name'    => 'required',
            'from_email'   => ['required', 'email'],
            'list_id'      => ['required', 'exists:email_lists,id'],
            'scheduled_at' => 'nullable|date',
        ];
    }
}
