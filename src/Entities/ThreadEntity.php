<?php

namespace Amarkhai\AirbnbSdk\Entities;

use Amarkhai\AirbnbSdk\Entities\Nested\ThreadAttachment;
use Amarkhai\AirbnbSdk\Entities\Nested\ThreadMessage;
use Amarkhai\AirbnbSdk\Entities\Nested\ThreadUser;
use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for the representation Threads in Messaging API
 */
class ThreadEntity
{
    public const BUSINESS_PURPOSE_BOOKING_DIRECT_THREAD = 'booking_direct_thread';
    public const BUSINESS_PURPOSE_COHOSTING_DIRECT_THREAD = 'cohosting_direct_thread';
    public const BUSINESS_PURPOSE_SUPPORT_MESSAGING_THREAD = 'support_messaging_thread';

    private const REQUIRED_FIELDS = [
        'id'
    ];
    private const FIELDS_EXCLUDED_FROM_EXPORT = [];

    private const NESTED_FIELDS = [
        'attachment' => ThreadAttachment::class,
    ];
    private const NESTED_FIELDS_ARRAY = [
        'users' => ThreadUser::class,
        'messages' => ThreadMessage::class,
    ];

    /**
     * Thread ID. Threads are unique between a host and guest. If there is not an existing thread between a host and a
     * guest, a new one is created. The number ID will be deprecated in the future, use string ID _str field instead
     * @var int
     */
    private $id;
    /**
     * String representation of id field.
     * @var string
     */
    private $id_str;
    /**
     * Identical to the id field, provided for a previous migration. The number ID will be deprecated in the future,
     * use string ID _str field instead.
     * @var int
     */
    private $thread_id_migration;
    /**
     * String representation of thread_id_migration field.
     * @var string
     */
    private $thread_id_migration_str;
    /**
     * Thread type; currently, three values are supported - booking_direct_thread, cohosting_direct_thread
     * and support_messaging_thread
     * @var string
     */
    private $business_purpose;
    /**
     * Date and time the thread was updated in ISO-8601 format. Not all thread events are messages, so updated_at is
     * always equal to or larger than last_message_sent_at.
     * @var string
     */
    private $updated_at;
    /**
     * Date and time last text message was sent in ISO-8601 format.
     * @var string
     */
    private $last_message_sent_at;

    /**
     * @var ThreadUser[]
     */
    private $users = [];
    /**
     * Information about attachments to this thread.
     * @var ThreadAttachment|null
     */
    private $attachment;
    /**
     * All thread messages sorted by date in ascending order. The same format as the Message Object, excluding
     * the thread_id.
     * @var ThreadMessage[]
     */
    private $messages = [];

    public function __construct(string $id_str)
    {
        $this->id_str = $id_str;
    }

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $threadData = get_object_vars($this);

        foreach (self::NESTED_FIELDS as $fieldName => $entityClassName) {
            if (isset($threadData[$fieldName])) {
                $threadData[$fieldName] = $threadData[$fieldName]->exportAsArray();
            }
        }

        foreach (self::NESTED_FIELDS_ARRAY as $fieldName => $entityClassName) {
            if (isset($threadData[$fieldName])) {
                $data = [];
                foreach ($threadData[$fieldName] as $item) {
                    $data = $item->exportAsArray();
                }
                $threadData[$fieldName] = $data;
            }
        }

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($threadData[$field]);
        }

        if ($withoutNulls) {
            foreach ($threadData as $fieldName => $value) {
                if (is_null($value)) {
                    unset($threadData[$fieldName]);
                }
            }
        }

        return $threadData;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function fillByArray(array $fields): ThreadEntity
    {
        foreach ($fields as $name => $value) {
            if (isset(self::NESTED_FIELDS[$name])) {
                $entityClass = self::NESTED_FIELDS[$name];
                $this->$name = $entityClass::createByArray($value);
            } elseif (isset(self::NESTED_FIELDS_ARRAY[$name])) {
                $entityClass = self::NESTED_FIELDS_ARRAY[$name];
                foreach ($value as $item) {
                    $this->$name[] =  $entityClass::createByArray($item);
                }
            } else {
                $this->$name = $value;
            }
        }

        return $this;
    }

    /**
     * @param array $data
     * @return ThreadEntity
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): ThreadEntity
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $thread = new self(
            'id'
        );

        $thread->fillByArray($data);

        return $thread;
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
    public function getIdStr(): string
    {
        return $this->id_str;
    }

    /**
     * @return int
     */
    public function getThreadIdMigration(): int
    {
        return $this->thread_id_migration;
    }

    /**
     * @return string
     */
    public function getThreadIdMigrationStr(): string
    {
        return $this->thread_id_migration_str;
    }

    /**
     * @return ThreadUser[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @return ThreadAttachment|null
     */
    public function getAttachment(): ?ThreadAttachment
    {
        return $this->attachment;
    }

    /**
     * @return ThreadMessage[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @return string
     */
    public function getLastMessageSentAt(): string
    {
        return $this->last_message_sent_at;
    }
}
