<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Model\VatPayerStatus\Account\NonStandard;

use LukeArthur\Adis\Model\Model;

/**
 * NonStandard section
 * property: nestandardniUcet
 * occurence: 0|1 (choice between this and Standard)
 *
 * @author LukeArthur
 */
class NonStandard extends Model
{
    protected static $attributeMap = [
        'cislo' => [
            self::MAP_ATTRIBUTE_NAME => 'number',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
    ];

    /**
     * @var string
     */
    protected $number;

    /**
     * @return string|null
     */
    public static function getPropertyName(): ?string
    {
        return 'nestandardniUcet';
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }
}
