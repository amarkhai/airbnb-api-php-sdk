<?php

namespace Amarkhai\AirbnbSdk\Entities\Nested;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for the representation Roles in Threads
 */
class ThreadRole
{
    public const ROLE_OWNER = 'owner';
    public const ROLE_GUEST = 'guest';
    public const ROLE_COHOST = 'cohost';

    private const REQUIRED_FIELDS = [
        'role'
    ];

    private const FIELDS_EXCLUDED_FROM_EXPORT = [];

    /**
     * Role name. Valid options are: owner, guest, cohost.
     * @var string
     */
    private $role;
    /**
     * Array of user_ids assigned to this role. Currently, API listings have only one owner.
     * @var int[]
     */
    private $user_ids = [];

    /**
     * ThreadRole constructor.
     * @param string $role
     */
    public function __construct(string $role)
    {
        $this->role = $role;
    }

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $roleData = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($roleData[$field]);
        }

        if ($withoutNulls) {
            foreach ($roleData as $fieldName => $value) {
                if (is_null($value)) {
                    unset($roleData[$fieldName]);
                }
            }
        }

        return $roleData;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function fillByArray(array $fields): ThreadRole
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return ThreadRole
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): ThreadRole
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $role = new self(
            $data['role']
        );

        $role->fillByArray($data);

        return $role;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return int[]
     */
    public function getUserIds(): array
    {
        return $this->user_ids;
    }
}
