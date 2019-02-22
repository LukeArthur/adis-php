<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Model\VatPayerStatus;

use LukeArthur\Adis\Model\Model;
use LukeArthur\Adis\Model\VatPayerStatus\PublishedAccounts\PublishedAccounts;

/**
 * VatPayerStatus section
 * property: statusPlatceDPH
 * occurence: 0+
 *
 * @author LukeArthur
 */
class VatPayerStatus extends Model
{
    public const UNRELIABLE_PAYER_YES = 'ANO';
    public const UNRELIABLE_PAYER_NO = 'NE';
    public const UNRELIABLE_PAYER_NOT_FOUND = 'NENALEZEN';

    protected static $attributeMap = [
        'dic' => [
            self::MAP_ATTRIBUTE_NAME => 'taxId',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
        'nespolehlivyPlatce' => [
            self::MAP_ATTRIBUTE_NAME => 'unreliablePayer',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
        'datumZverejneniNespolehlivosti' => [
            self::MAP_ATTRIBUTE_NAME => 'unreliablePublishDate',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_DATE,
        ],
        'cisloFu' => [
            self::MAP_ATTRIBUTE_NAME => 'taxOfficeNumber',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
    ];

    /**
     * @var string
     */
    protected $taxId;

    /**
     * @var string
     */
    protected $unreliablePayer;

    /**
     * @var \DateTime|null
     */
    protected $unreliablePublishDate;

    /**
     * @var string|null
     */
    protected $taxOfficeNumber;

    /**
     * @var \LukeArthur\Adis\Model\VatPayerStatus\PublishedAccounts\PublishedAccounts|null
     */
    protected $publishedAccounts;

    /**
     * @return string|null
     */
    public static function getPropertyName(): ?string
    {
        return 'statusPlatceDPH';
    }

    /**
     * @param \stdClass $response
     * @param array $path
     */
    public function parse(\stdClass $response, array $path = [])
    {
        parent::parse($response, $path);

        if (\property_exists($response, PublishedAccounts::getPropertyName())) {
            $this->publishedAccounts = new PublishedAccounts();
            $this->publishedAccounts->parse(
                $response->{PublishedAccounts::getPropertyName()},
                $this->addToPath($path, PublishedAccounts::getPropertyName())
            );
        }
    }

    /**
     * @return string
     */
    public function getTaxId(): string
    {
        return $this->taxId;
    }

    /**
     * @return string
     */
    public function getUnreliablePayer(): string
    {
        return $this->unreliablePayer;
    }

    /**
     * @return string
     */
    public function getTaxOfficeNumber(): string
    {
        return $this->taxOfficeNumber;
    }

    /**
     * @return \LukeArthur\Adis\Model\VatPayerStatus\PublishedAccounts\PublishedAccounts|null
     */
    public function getPublishedAccounts(): ?PublishedAccounts
    {
        return $this->publishedAccounts;
    }

    /**
     * @return bool
     */
    public function isUnreliablePayer(): bool
    {
        return static::UNRELIABLE_PAYER_YES === $this->getUnreliablePayer();
    }

    /**
     * @return bool
     */
    public function isReliablePayer(): bool
    {
        return static::UNRELIABLE_PAYER_NO === $this->getUnreliablePayer();
    }
}
