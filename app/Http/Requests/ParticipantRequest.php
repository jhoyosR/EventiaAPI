<?php

namespace App\Http\Requests;

use App\Models\Participant\Traits\Rules\ParticipantRules;

class ParticipantRequest extends BaseRequest {
    use ParticipantRules;

    // Asigna reglas según método
    protected function rulesByAction(): array {
        return [
            'store'  => $this->createdRules(),
            'update' => $this->updatedRules(),
        ];
    }
}
