<?php

namespace Amarkhai\AirbnbSdk\Entities\Nested;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for the representation Users in Threads
 */
class ThreadUser
{
    private const REQUIRED_FIELDS = [
        'id'
    ];

    private const FIELDS_EXCLUDED_FROM_EXPORT = [];

    /**
     * User's ID.
     * @var int
     */
    private $id;

    /**
     * User's first name.
     * @var string
     */
    private $first_name;
    /**
     * User's preferred locale.
     * See the list of supported locales: https://developer.airbnb.com/reference/supported-locales
     * @var string|null
     */
    private $preferred_locale;
    /**
     * User's location.
     * @var string|null
     */
    private $location;

    /**
     * ThreadUser constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function exportAsArray(bool $withoutNulls = false): array
    {
        $userData = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($userData[$field]);
        }

        if ($withoutNulls) {
            foreach ($userData as $fieldName => $value) {
                if (is_null($value)) {
                    unset($userData[$fieldName]);
                }
            }
        }

        return $userData;
    }

    public function fillByArray(array $fields): ThreadUser
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    public static function createByArray(array $data): ThreadUser
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $user = new self($data['id']);

        $user->fillByArray($data);

        return $user;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string|null
     */
    public function getPreferredLocale(): ?string
    {
        return $this->preferred_locale;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }
}
