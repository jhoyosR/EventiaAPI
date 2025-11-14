<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterParticipantRequest extends FormRequest {

    public function rules(): array {
        return [
            'participant_id' => ['required', 'integer', 'exists:participants,id'],
        ];
    }
}
