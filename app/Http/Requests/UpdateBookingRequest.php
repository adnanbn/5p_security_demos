<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:120'],
            'starts_at' => ['sometimes', 'date'],
            'reference' => ['prohibited'],
            'user_id' => ['prohibited'],
            'status' => ['prohibited'],
            'private_notes' => ['prohibited'],
        ];
    }
}
