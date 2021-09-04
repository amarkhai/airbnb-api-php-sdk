<?php

namespace Amarkhai\AirbnbSdk\Entities\Parameters;

/**
 * Parameters for the method "Get all listings" of the Listings API
 */
class GetAllListingsParameters
{
    /**
     * Set this to false if all user listings (including unlisted) should be returned. If not specified, only the
     * listed listings are returned.
     * @var bool
     */
    private $has_availability = true;
    /**
     * If true, only the unlisted listings are returned. Default is false
     * @var bool
     */
    private $exclude_active = false;
    /**
     * If true, only the owned listings are returned. Default is false.
     * @var bool
     */
    private $exclude_cohosted_listings = false;
    /**
     * The maximum number of listings to return, up to 50. Default is 20.
     * @var int
     */
    private $_limit = 20;
    /**
     * @deprecated
     * The number of listings to skip over, where the ordering is consistent but unspecified. Default is 0.
     * (deprecated as of Jan 2022)
     * @var int
     */
    private $_offset = 0;
    /**
     * Cursor to retrieve subsequent pages of results.
     * @var int
     */
    private $_cursor;

    /**
     * @param bool $has_availability
     * @return GetListingsParameters
     */
    public function setHasAvailability(bool $has_availability): GetListingsParameters
    {
        $this->has_availability = $has_availability;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHasAvailability(): bool
    {
        return $this->has_availability;
    }

    /**
     * @param bool $exclude_active
     * @return GetListingsParameters
     */
    public function setExcludeActive(bool $exclude_active): GetListingsParameters
    {
        $this->exclude_active = $exclude_active;
        return $this;
    }

    /**
     * @return bool
     */
    public function isExcludeActive(): bool
    {
        return $this->exclude_active;
    }

    /**
     * @param bool $exclude_cohosted_listings
     * @return GetListingsParameters
     */
    public function setExcludeCohostedListings(bool $exclude_cohosted_listings): GetListingsParameters
    {
        $this->exclude_cohosted_listings = $exclude_cohosted_listings;
        return $this;
    }

    /**
     * @return bool
     */
    public function isExcludeCohostedListings(): bool
    {
        return $this->exclude_cohosted_listings;
    }

    /**
     * @param int $limit
     * @return GetListingsParameters
     */
    public function setLimit(int $limit): GetListingsParameters
    {
        $this->_limit = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->_limit;
    }

    /**
     * @deprecated
     * @param int $offset
     * @return GetListingsParameters
     */
    public function setOffset(int $offset): GetListingsParameters
    {
        $this->_offset = $offset;
        return $this;
    }

    /**
     * @deprecated
     * @return int
     */
    public function getOffset(): int
    {
        return $this->_offset;
    }

    /**
     * @param int $cursor
     * @return GetListingsParameters
     */
    public function setCursor(int $cursor): GetListingsParameters
    {
        $this->_cursor = $cursor;
        return $this;
    }

    /**
     * @return int
     */
    public function getCursor(): int
    {
        return $this->_cursor;
    }
}
