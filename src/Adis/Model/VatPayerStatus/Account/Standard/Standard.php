<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Model\VatPayerStatus\Account\Standard;

use LukeArthur\Adis\Model\Model;

/**
 * Standard section
 * property: standardniUcet
 * occurence: 0|1 (choice between this and NonStandard)
 *
 * @author LukeArthur
 */
class Standard extends Model
{
    protected static $attributeMap = [
        'predcisli' => [
            self::MAP_ATTRIBUTE_NAME => 'prefix',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
        'cislo' => [
            self::MAP_ATTRIBUTE_NAME => 'number',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
        'kodBanky' => [
            self::MAP_ATTRIBUTE_NAME => 'bankCode',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
    ];

    /**
     * @var string|null
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var string
     */
    protected $bankCode;

    /**
     * @return string|null
     */
    public static function getPropertyName(): ?string
    {
        return 'standardniUcet';
    }

    /**
     * @return string|null
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getBankCode(): string
    {
        return $this->bankCode;
    }
}
