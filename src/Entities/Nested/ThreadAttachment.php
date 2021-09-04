<?php

namespace Amarkhai\AirbnbSdk\Entities\Nested;

use Amarkhai\AirbnbSdk\Exceptions\EmptyRequiredFieldsException;

/**
 * The entity for the representation Attachments in Threads
 */
class ThreadAttachment
{
    public const TYPE_INQUIRY = 'Inquiry';
    public const TYPE_SPECIAL_OFFER = 'SpecialOffer';
    public const TYPE_RESERVATION = 'Reservation';

    private const REQUIRED_FIELDS = [
        'type',
        'status',
    ];
    private const FIELDS_EXCLUDED_FROM_EXPORT = [];

    private const NESTED_FIELDS = [
        'booking_details' => ThreadBookingDetails::class,
    ];
    private const NESTED_FIELDS_ARRAY = [
        'roles' => ThreadRole::class,
    ];

    /**
     * Attachment type. Can be one of Inquiry, SpecialOffer, or Reservation.
     * @var string
     */
    private $type;
    /**
     * Valid values depend on the type of attachment.
     * See the list of valid message statuses: https://developer.airbnb.com/docs/message-status
     * @var string
     */
    private $status;
    /**
     * Detailed human-readable value for the status of the thread attachment.
     * @var string|null
     */
    private $status_details;
    /**
     * Role object array representing users' roles in the thread.
     * @var ThreadRole[]
     */
    private $roles = [];
    /**
     * @var ThreadBookingDetails|null
     */
    private $booking_details;

    /**
     * ThreadAttachment constructor.
     * @param string $type
     * @param string $status
     */
    public function __construct(string $type, string $status)
    {
        $this->type = $type;
        $this->status = $status;
    }

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $attachmentData = get_object_vars($this);

        foreach (self::NESTED_FIELDS as $fieldName => $entityClassName) {
            if (isset($attachmentData[$fieldName])) {
                $attachmentData[$fieldName] = $attachmentData[$fieldName]->exportAsArray();
            }
        }

        foreach (self::NESTED_FIELDS_ARRAY as $fieldName => $entityClassName) {
            if (isset($attachmentData[$fieldName])) {
                $data = [];
                foreach ($attachmentData[$fieldName] as $item) {
                    $data = $item->exportAsArray();
                }
                $attachmentData[$fieldName] = $data;
            }
        }

        foreach (self::FIELDS_EXCLUDED_FROM_EXPORT as $field) {
            unset($attachmentData[$field]);
        }

        if ($withoutNulls) {
            foreach ($attachmentData as $fieldName => $value) {
                if (is_null($value)) {
                    unset($attachmentData[$fieldName]);
                }
            }
        }

        return $attachmentData;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function fillByArray(array $fields): ThreadAttachment
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
     * @return ThreadAttachment
     * @throws EmptyRequiredFieldsException
     */
    public static function createByArray(array $data): ThreadAttachment
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($data[$field])) {
                throw new EmptyRequiredFieldsException(sprintf(
                    'Some of required fields is absent: %s',
                    implode(',', self::REQUIRED_FIELDS)
                ));
            }
        }

        $attachment = new self(
            $data['type'],
            $data['status']
        );

        $attachment->fillByArray($data);

        return $attachment;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getStatusDetails(): ?string
    {
        return $this->status_details;
    }

    /**
     * @return ThreadRole[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return ThreadBookingDetails|null
     */
    public function getBookingDetails(): ?ThreadBookingDetails
    {
        return $this->booking_details;
    }
}
