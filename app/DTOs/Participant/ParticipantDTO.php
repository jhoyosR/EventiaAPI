<?php 

namespace App\DTOs\Participant;

/**
 * DTO para creación del modelo
 */
class ParticipantDTO {

    /** Constructor */
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $phone_number,
        private readonly string $identification,
        private readonly string $birth_date,
    ) {}

    /**
     * Obtencion de datos desde array
     *
     * @param array $data Datos del modelo
     */
    public static function fromArray(array $data): ParticipantDTO {
        return new self(
            name           : data_get(target: $data, key: 'name'),
            email          : data_get(target: $data, key: 'email'),
            phone_number   : data_get(target: $data, key: 'phone_number'),
            identification : data_get(target: $data, key: 'identification'),
            birth_date     : data_get(target: $data, key: 'birth_date'),
        );
    }

    /** Datos del modelo */
    public function toArray(): array {
        return [
            'name'           => $this->name,
            'email'          => $this->email,
            'phone_number'   => $this->phone_number,
            'identification' => $this->identification,
            'birth_date'     => $this->birth_date,
        ];
    }

}