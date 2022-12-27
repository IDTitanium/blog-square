<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\Casting\CarbonImmutableCast;
use WendellAdriel\ValidatedDTO\Casting\IntegerCast;
use WendellAdriel\ValidatedDTO\Casting\StringCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class PostDTO extends ValidatedDTO
{
    public $id;

    public $title;

    public $description;

    public $publishedAt;
    /**
     * Defines the validation rules for the DTO.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'required|string',
            'publishedAt' => 'sometimes'
        ];
    }

    /**
     * Defines the default values for the properties of the DTO.
     *
     * @return array
     */
    protected function defaults(): array
    {
        return [];
    }

    /**
     * Defines the type casting for the properties of the DTO.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'id' => new IntegerCast(),
            'title' => new StringCast(),
            'description' => new StringCast(),
            'publishedAt' => new CarbonImmutableCast()
        ];
    }

    /**
     * Defines the custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Defines the custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }
}
