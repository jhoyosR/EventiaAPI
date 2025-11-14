<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest {

    /**
     * Determina si el usuario está autorizado para hacer esta petición.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Devuelve los atributos traducidos del modelo si existen.
     */
    public function attributes(): array {
        if (method_exists($this->modelClass(), 'attributes')) {
            return $this->modelClass()::attributes();
        }
        return [];
    }

    /**
     * Cada Request hijo debe devolver la clase del modelo asociado.
     */
    abstract protected function modelClass(): string;

    /**
     * Define las reglas por método de controlador.
     * Ejemplo: return ['store' => [...], 'update' => [...]];
     */
    abstract protected function rulesByAction(): array;

    /**
     * Retorna las reglas según el método del controlador.
     */
    public function rules(): array {
        $action = $this->getControllerMethod();
        return $this->rulesByAction()[$action] ?? [];
    }

}
