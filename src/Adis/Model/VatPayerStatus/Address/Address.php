<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Model\VatPayerStatus\Address;

use LukeArthur\Adis\Model\Model;

/**
 * Address section
 * property: adresa
 * occurence: 0|1
 *
 * @author LukeArthur
 */
class Address extends Model
{
    protected static $attributeMap = [
        'uliceCislo' => [
            self::MAP_ATTRIBUTE_NAME => 'streetAndNumber',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
        'castObce' => [
            self::MAP_ATTRIBUTE_NAME => 'district',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
        'mesto' => [
            self::MAP_ATTRIBUTE_NAME => 'city',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
        'psc' => [
            self::MAP_ATTRIBUTE_NAME => 'zipCode',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
        'stat' => [
            self::MAP_ATTRIBUTE_NAME => 'country',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
    ];

    /**
     * @var string
     */
    protected $streetAndNumber;

    /**
     * @var string|null
     */
    protected $district;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $zipCode;

    /**
     * @var string
     */
    protected $country;

    /**
     * @return string|null
     */
    public static function getPropertyName(): ?string
    {
        return 'adresa';
    }

    /**
     * @return string
     */
    public function getStreetAndNumber(): string
    {
        return $this->streetAndNumber;
    }

    /**
     * @return string|null
     */
    public function getDistrict(): ?string
    {
        return $this->district;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }
}
