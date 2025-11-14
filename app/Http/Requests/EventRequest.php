<?php

namespace App\Http\Requests;

use App\Models\Event\Traits\Rules\EventRules;

class EventRequest extends BaseRequest {
    use EventRules;

    // Asigna reglas según método
    protected function rulesByAction(): array {
        return [
            'store'  => $this->createdRules(),
            'update' => $this->updatedRules(),
        ];
    }
}
