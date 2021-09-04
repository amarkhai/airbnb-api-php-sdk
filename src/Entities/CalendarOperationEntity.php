<?php

namespace Amarkhai\AirbnbSdk\Entities;

/**
 * The entity for the representations operations in Async Calendar Batch Operations
 */
class CalendarOperationEntity
{
    public const AVAILABILITY_TYPE_AVAILABLE = 'available';
    public const AVAILABILITY_TYPE_UNAVAILABLE = 'unavailable';
    public const AVAILABILITY_TYPE_DEFAULT = 'default';

    /**
     * Nightly price for this day. Minimum = 10 USD, maximum = 25000 USD. 0 is allowed for test listings created in
     * sandbox app for making test reservations. Non-zero value less than minimum is not allowed for test listings.
     * @var int
     */
    private $daily_price;
    /**
     * Either "available", "unavailable" or "default". Please use "default" instead of "available" if you want the day
     * to comply with any availability rules you set, since "available" overwrites any availability rules.
     * @var string
     */
    private $availability = 'default';
    /**
     * Minimum length of stay if the trip starts on this day. Use null to unset this value.
     * @var int|null
     */
    private $min_nights;
    /**
     * Maximum length of stay if the trip starts on this day. Use null to unset this value.
     * @var int|null
     */
    private $max_nights;
    /**
     * When true, the guest cannot check in on this day. default is false
     * @var bool
     */
    private $closed_to_arrival = false;
    /**
     * When true, the guest cannot check out on this day. default is false
     * @var bool
     */
    private $closed_to_departure = false;
    /**
     * Optional notes.
     * @var string|null
     */
    private $notes;

    /**
     * CalendarInfoEntity constructor.
     * @param int $dailyPrice
     */
    public function __construct(int $dailyPrice)
    {
        $this->daily_price = $dailyPrice;
    }

    /**
     * @param bool $withoutNulls
     * @return array
     */
    public function exportAsArray(bool $withoutNulls = false): array
    {
        $calendarInfo = get_object_vars($this);

        if ($withoutNulls) {
            foreach ($calendarInfo as $fieldName => $value) {
                if (is_null($value)) {
                    unset($calendarInfo[$fieldName]);
                }
            }
        }

        return $calendarInfo;
    }

    /**
     * @param int $daily_price
     * @return CalendarOperationEntity
     */
    public function setDailyPrice(int $daily_price): CalendarOperationEntity
    {
        $this->daily_price = $daily_price;
        return $this;
    }

    /**
     * @return int
     */
    public function getDailyPrice(): int
    {
        return $this->daily_price;
    }

    /**
     * @param string $availability
     * @return CalendarOperationEntity
     */
    public function setAvailability(string $availability): CalendarOperationEntity
    {
        $this->availability = $availability;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvailability(): string
    {
        return $this->availability;
    }

    /**
     * @param int|null $min_nights
     * @return CalendarOperationEntity
     */
    public function setMinNights(?int $min_nights): CalendarOperationEntity
    {
        $this->min_nights = $min_nights;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinNights(): ?int
    {
        return $this->min_nights;
    }

    /**
     * @param int|null $max_nights
     * @return CalendarOperationEntity
     */
    public function setMaxNights(?int $max_nights): CalendarOperationEntity
    {
        $this->max_nights = $max_nights;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxNights(): ?int
    {
        return $this->max_nights;
    }

    /**
     * @param bool $closed_to_arrival
     * @return CalendarOperationEntity
     */
    public function setClosedToArrival(bool $closed_to_arrival): CalendarOperationEntity
    {
        $this->closed_to_arrival = $closed_to_arrival;
        return $this;
    }

    /**
     * @return bool
     */
    public function isClosedToArrival(): bool
    {
        return $this->closed_to_arrival;
    }

    /**
     * @param bool $closed_to_departure
     * @return CalendarOperationEntity
     */
    public function setClosedToDeparture(bool $closed_to_departure): CalendarOperationEntity
    {
        $this->closed_to_departure = $closed_to_departure;
        return $this;
    }

    /**
     * @return bool
     */
    public function isClosedToDeparture(): bool
    {
        return $this->closed_to_departure;
    }

    /**
     * @param string|null $notes
     * @return CalendarOperationEntity
     */
    public function setNotes(?string $notes): CalendarOperationEntity
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }
}
