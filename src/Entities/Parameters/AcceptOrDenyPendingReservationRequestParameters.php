<?php

namespace Amarkhai\AirbnbSdk\Entities\Parameters;

/**
 * Parameters for the method "Accept or deny pending reservation request" of the Reservation API
 */
class AcceptOrDenyPendingReservationRequestParameters
{
    public const ATTEMPT_ACTION_ACCEPT = 'accept';
    public const ATTEMPT_ACTION_DENY = 'deny';

    public const DECLINE_REASON_DATES_NOT_AVAILABLE = 'dates_not_available';
    public const DECLINE_REASON_NOT_A_GOOD_FIT = 'not_a_good_fit';
    public const DECLINE_REASON_WAITING_FOR_BETTER_RESERVATION = 'waiting_for_better_reservation';
    public const DECLINE_REASON_NOT_COMFORTABLE = 'not_comfortable';

    /**
     * Accept or decline (deny) the request.
     * @var string
     */
    private $attempt_action;

    /**
     * An Airbnb-provided reason for declining the reservation request. If the reservation is declined, this field is
     * mandatory.
     * @var string|null
     */
    private $decline_reason;

    /**
     * A reply message to the guest that explains the need to decline. If the reservation is declined, this field is
     * mandatory.
     * @var string|null
     */
    private $decline_message_to_guest;

    /**
     * A optional private message sent to Airbnb when the reservation request is declined. The guest does not see this
     * message.
     * @var string|null
     */
    private $decline_message_to_airbnb;

    /**
     * AcceptOrDenyPendingReservation constructor.
     * @param string $attemptAction
     */
    public function __construct(string $attemptAction)
    {
        $this->attempt_action = $attemptAction;
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
     * @param string $attempt_action
     * @return AcceptOrDenyPendingReservationRequestParameters
     */
    public function setAttemptAction(string $attempt_action): AcceptOrDenyPendingReservationRequestParameters
    {
        $this->attempt_action = $attempt_action;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttemptAction(): string
    {
        return $this->attempt_action;
    }

    /**
     * @param string|null $decline_reason
     * @return AcceptOrDenyPendingReservationRequestParameters
     */
    public function setDeclineReason(?string $decline_reason): AcceptOrDenyPendingReservationRequestParameters
    {
        $this->decline_reason = $decline_reason;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeclineReason(): ?string
    {
        return $this->decline_reason;
    }

    /**
     * @param string|null $decline_message_to_guest
     * @return AcceptOrDenyPendingReservationRequestParameters
     */
    public function setDeclineMessageToGuest(?string $decline_message_to_guest): AcceptOrDenyPendingReservationRequestParameters
    {
        $this->decline_message_to_guest = $decline_message_to_guest;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeclineMessageToGuest(): ?string
    {
        return $this->decline_message_to_guest;
    }

    /**
     * @param string|null $decline_message_to_airbnb
     * @return AcceptOrDenyPendingReservationRequestParameters
     */
    public function setDeclineMessageToAirbnb(?string $decline_message_to_airbnb): AcceptOrDenyPendingReservationRequestParameters
    {
        $this->decline_message_to_airbnb = $decline_message_to_airbnb;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeclineMessageToAirbnb(): ?string
    {
        return $this->decline_message_to_airbnb;
    }
}
