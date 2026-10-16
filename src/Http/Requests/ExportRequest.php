<?php

declare(strict_types=1);

namespace JustBetter\ReplicatorTransfer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'value' => ['required', 'array'],
            'value.*' => [],
            'meta' => ['nullable', 'array'],
        ];
    }
}
