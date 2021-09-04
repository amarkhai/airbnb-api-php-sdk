<?php

namespace Amarkhai\AirbnbSdk\Entities\Parameters;

/**
 * Parameters for the method "Retrieve all reservations." of the Reservation API
 */
class RetrieveAllReservationsParameters
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_DENY = 'deny';
    public const STATUS_TIMEOUT = 'timeout';
    public const STATUS_ACCEPT = 'accept';
    public const STATUS_CANCELLED_BY_HOST = 'cancelled_by_host';
    public const STATUS_CANCELLED_BY_GUEST = 'cancelled_by_guest';
    public const STATUS_CANCELLED_BY_ADMIN = 'cancelled_by_admin';

    /**
     * Host's User ID in Airbnb
     * @var int
     */
    private $host_id;

    /**
     * Listing ID
     * @var int|null
     */
    private $listing_id;

    /**
     * Beginning of the date range, in ISO 8601 YYYY-MM-DD format. Returns the reservations that start on or after this
     * date.
     * @var string|null
     */
    private $start_date;

    /**
     * End of the date range, in ISO 8601 YYYY-MM-DD format. Returns the reservations that end before this date.
     * Default is 1 year.
     * @var int|null
     */
    private $end_date;

    /**
     * Set to true to return all reservations. False by default, so only accepted reservations are returned.
     * Should be 'true', 'false' or null
     * @var string|null
     */
    private $all_status;

    /**
     * Returns only the reservations with a specific status. Must be one of the supported query statuses. Mutually
     * exclusive with all_status parameter.
     * @var string|null
     */
    private $include_only_status;

    /**
     * Maximum number of reservations to return, up to 50.
     * @var int|null
     */
    private $_limit;

    /**
     * Number of reservations to skip over, where the ordering is consistent but unspecified. For example, to get the
     * 10th through 14th reservations, use _limit=5 and _offset=9. (deprecated as of Jan 2022)
     * @var int|null
     * @deprecated
     */
    private $_offset;

    /**
     * Cursor to retrieve subsequent pages of results.
     * @var string|null
     */
    private $_cursor;

    /**
     * RetrieveAllReservationsParameters constructor.
     * @param int $hostID
     */
    public function __construct(int $hostID)
    {
        $this->host_id = $hostID;
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
     * @return int
     */
    public function getHostId(): int
    {
        return $this->host_id;
    }

    /**
     * @param int $host_id
     * @return RetrieveAllReservationsParameters
     */
    public function setHostId(int $host_id): RetrieveAllReservationsParameters
    {
        $this->host_id = $host_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getListingId(): ?int
    {
        return $this->listing_id;
    }

    /**
     * @param int|null $listing_id
     * @return RetrieveAllReservationsParameters
     */
    public function setListingId(?int $listing_id): RetrieveAllReservationsParameters
    {
        $this->listing_id = $listing_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->start_date;
    }

    /**
     * @param string|null $start_date
     * @return RetrieveAllReservationsParameters
     */
    public function setStartDate(?string $start_date): RetrieveAllReservationsParameters
    {
        $this->start_date = $start_date;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getEndDate(): ?int
    {
        return $this->end_date;
    }

    /**
     * @param string|null $end_date
     * @return RetrieveAllReservationsParameters
     */
    public function setEndDate(?string $end_date): RetrieveAllReservationsParameters
    {
        $this->end_date = $end_date;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllStatus(): ?bool
    {
        switch ($this->all_status) {
            case 'true':
                return true;
            case 'false':
                return false;
            default:
                return null;
        }
    }

    /**
     * @param bool|null $all_status
     * @return RetrieveAllReservationsParameters
     */
    public function setAllStatus(?bool $all_status): RetrieveAllReservationsParameters
    {
        if ($all_status === true) {
            $this->all_status = 'true';
        } elseif ($all_status === false) {
            $this->all_status = 'false';
        } else {
            $this->all_status = $all_status;
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIncludeOnlyStatus(): ?string
    {
        return $this->include_only_status;
    }

    /**
     * @param string|null $include_only_status
     * @return RetrieveAllReservationsParameters
     */
    public function setIncludeOnlyStatus(?string $include_only_status): RetrieveAllReservationsParameters
    {
        $this->include_only_status = $include_only_status;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->_limit;
    }

    /**
     * @param int|null $limit
     * @return RetrieveAllReservationsParameters
     */
    public function setLimit(?int $limit): RetrieveAllReservationsParameters
    {
        $this->_limit = $limit;
        return $this;
    }

    /**
     * @deprecated
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->_offset;
    }

    /**
     * @deprecated
     * @param int|null $offset
     * @return RetrieveAllReservationsParameters
     */
    public function setOffset(?int $offset): RetrieveAllReservationsParameters
    {
        $this->_offset = $offset;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCursor(): ?string
    {
        return $this->_cursor;
    }

    /**
     * @param string|null $cursor
     * @return RetrieveAllReservationsParameters
     */
    public function setCursor(?string $cursor): RetrieveAllReservationsParameters
    {
        $this->_cursor = $cursor;
        return $this;
    }
}
