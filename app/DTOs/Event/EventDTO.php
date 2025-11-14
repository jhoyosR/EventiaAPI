<?php 

namespace App\DTOs\Event;

/**
 * DTO para creación del modelo
 */
class EventDTO {

    /** Constructor */
    public function __construct(
        private readonly string $name,
        private readonly string $description,
        private readonly string $datetime,
        private readonly string $location,
        private readonly int    $capacity,
    ) {}

    /**
     * Obtencion de datos desde array
     *
     * @param array $data Datos del modelo
     */
    public static function fromArray(array $data): EventDTO {
        return new self(
            name        : data_get(target: $data, key: 'name'),
            description : data_get(target: $data, key: 'description'),
            datetime    : data_get(target: $data, key: 'datetime'),
            location    : data_get(target: $data, key: 'location'),
            capacity    : data_get(target: $data, key: 'capacity'),
        );
    }

    /** Datos del modelo */
    public function toArray(): array {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'datetime'    => $this->datetime,
            'location'    => $this->location,
            'capacity'    => $this->capacity,
        ];
    }

}