<?php

namespace Amarkhai\AirbnbSdk\Entities;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for representation Messages
 */
class MessageEntity
{
    private const REQUIRED_FIELDS = [
        'thread_id'
    ];

    private const FIELDS_EXCLUDED_FROM_EXPORT = [];

    /**
     * Thread ID
     * @var int
     */
    private $thread_id;
    /**
     * Message text
     * @var string|null
     */
    private $message;
    /**
     * Attachment image contents in base64 string format. Images cannot be larger then 25MB and are auto-cropped.
     * Text message is ignored if image is passed.
     * @var string|null
     */
    private $image;
    /**
     * Image MIME content type.
     * @var string|null
     */
    private $content_type;

    /**
     * MessageEntity constructor.
     * @param string $thread_id
     */
    public function __construct(string $thread_id)
    {
        $this->thread_id = $thread_id;
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
    public function fillByArray(array $fields): MessageEntity
    {
        foreach ($fields as $name => $value) {
            $this->$name = $value;
        }

        return $this;
    }

    /**
     * @param array $data
     * @return MessageEntity
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): MessageEntity
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
            $data['thread_id']
        );

        $message->fillByArray($data);

        return $message;
    }

    /**
     * @param int $thread_id
     * @return MessageEntity
     */
    public function setThreadId($thread_id): MessageEntity
    {
        $this->thread_id = $thread_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getThreadId()
    {
        return $this->thread_id;
    }

    /**
     * @param string|null $message
     * @return MessageEntity
     */
    public function setMessage(?string $message): MessageEntity
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $image
     * @return MessageEntity
     */
    public function setImage(?string $image): MessageEntity
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $content_type
     * @return MessageEntity
     */
    public function setContentType(?string $content_type): MessageEntity
    {
        $this->content_type = $content_type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContentType(): ?string
    {
        return $this->content_type;
    }
}
