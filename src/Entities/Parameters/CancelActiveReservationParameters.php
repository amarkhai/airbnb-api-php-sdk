<?php

namespace Amarkhai\AirbnbSdk\Entities\Parameters;

/**
 * Parameters for the method "Cancel an active reservation" of the Reservation API
 */
class CancelActiveReservationParameters
{
    public const STATUS_TYPE_CANCELLED_BY_HOST = 'cancelled_by_host';

    /**
     * Cancel the reservation, as a host.
     * @var string
     */
    private $status_type;

    /**
     * An Airbnb-provided reason for cancelling the reservation. Only values which are returned in the GET response are
     * valid.
     * @var string
     */
    private $reason;

    /**
     * An Airbnb-provided sub-reason for cancelling the reservation. Only values which are returned in the GET response
     * are valid.
     * @var string|null
     */
    private $sub_reason;

    /**
     * A message to the guest that explains the need to cancel.
     * @var string|null
     */
    private $message_to_guest;

    /**
     * A private message sent to Airbnb when the reservation is cancelled. The guest does not see this message.
     * @var string|null
     */
    private $message_to_airbnb;

    /**
     * CancelActiveReservation constructor.
     * @param string $statusType
     * @param string $reason
     */
    public function __construct(string $statusType, string $reason)
    {
        $this->status_type = $statusType;
        $this->reason = $reason;
    }

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $parameters = get_object_vars($this);

        if ($withoutNulls) {
            foreach ($parameters as $fieldName => $value) {
                if (is_null($value)) {
                    unset($parameters[$fieldName]);
                }
            }
        }

        return $parameters;
    }

    /**
     * @param string $status_type
     * @return CancelActiveReservation
     */
    public function setStatusType(string $status_type): CancelActiveReservation
    {
        $this->status_type = $status_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusType(): string
    {
        return $this->status_type;
    }

    /**
     * @param string $reason
     * @return CancelActiveReservation
     */
    public function setReason(string $reason): CancelActiveReservation
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string|null $sub_reason
     * @return CancelActiveReservation
     */
    public function setSubReason(?string $sub_reason): CancelActiveReservation
    {
        $this->sub_reason = $sub_reason;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubReason(): ?string
    {
        return $this->sub_reason;
    }

    /**
     * @param string|null $message_to_guest
     * @return CancelActiveReservation
     */
    public function setMessageToGuest(?string $message_to_guest): CancelActiveReservation
    {
        $this->message_to_guest = $message_to_guest;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessageToGuest(): ?string
    {
        return $this->message_to_guest;
    }

    /**
     * @param string|null $message_to_airbnb
     * @return CancelActiveReservation
     */
    public function setMessageToAirbnb(?string $message_to_airbnb): CancelActiveReservation
    {
        $this->message_to_airbnb = $message_to_airbnb;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessageToAirbnb(): ?string
    {
        return $this->message_to_airbnb;
    }
}
