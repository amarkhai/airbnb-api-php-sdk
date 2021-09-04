<?php

namespace Amarkhai\AirbnbSdk\Entities\Nested;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for representation Messages in Threads
 */
class ThreadMessage
{
    private const REQUIRED_FIELDS = [
        'id_str',
        'message',
        'user_id',
    ];

    private const FIELDS_EXCLUDED_FROM_EXPORT = [];

    /**
     * The ID of this message. The number ID will be deprecated in the future, use string ID _str field instead
     * @var int|null
     */
    private $id;
    /**
     * String representation of the id field.
     * @var string
     */
    private $id_str;
    /**
     * Message text. This will be an empty string if images are attached.
     * @var string
     */
    private $message;
    /**
     * The date and time this image was created in ISO-8601 format.
     * @var string|null
     */
    private $created_at;
    /**
     * Attached images
     * @var array[]
     * array like [['url' => String], ...] or []
     * url - Image URL
     */
    private $attachment_images = [];
    /**
     * Image MIME type if message contains an image.
     * @var string|null
     */
    private $content_type;
    /**
     * Message sender's int64 User ID.
     * @var string
     */
    private $user_id;
    /**
     * Thread ID
     * @var int|null
     */
    private $thread_id;
    /**
     * Thread ID str
     * @var int|null
     */
    private $thread_id_str;

    /**
     * ThreadMessage constructor.
     * @param string $id_str
     * @param string $message
     * @param string $user_id
     */
    public function __construct(string $id_str, string $message, string $user_id)
    {
        $this->id_str = $id_str;
        $this->message = $message;
        $this->user_id = $user_id;
    }

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $messageData = get_object_vars($this);

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($messageData[$field]);
        }

        if ($withoutNulls) {
            foreach ($messageData as $fieldName => $value) {
                if (is_null($value)) {
                    unset($messageData[$fieldName]);
                }
            }
        }

        return $messageData;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function fillByArray(array $fields): ThreadMessage
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return ThreadMessage
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): ThreadMessage
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $message = new self(
            $data['id_str'],
            $data['message'],
            $data['user_id']
        );

        $message->fillByArray($data);

        return $message;
    }

    /**
     * @return string
     */
    public function getIdStr(): string
    {
        return $this->id_str;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getAttachmentImages(): array
    {
        return $this->attachment_images;
    }

    /**
     * @return string|null
     */
    public function getContentType(): ?string
    {
        return $this->content_type;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * @return int|null
     */
    public function getThreadId(): ?int
    {
        return $this->thread_id;
    }

    /**
     * @return int|null
     */
    public function getThreadIdStr(): ?int
    {
        return $this->thread_id_str;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }
}
