<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Model\VatPayerStatus\Account;

use LukeArthur\Adis\Model\Model;
use LukeArthur\Adis\Model\VatPayerStatus\Account\NonStandard\NonStandard;
use LukeArthur\Adis\Model\VatPayerStatus\Account\Standard\Standard;

/**
 * Account section
 * property: ucet
 * occurence: 1+
 *
 * @author LukeArthur
 */
class Account extends Model
{
    protected static $attributeMap = [
        'datumZverejneni' => [
            self::MAP_ATTRIBUTE_NAME => 'dateOfPublishing',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_DATE,
        ],
    ];

    /**
     * @var \DateTime
     */
    protected $dateOfPublishing;

    /**
     * @var \LukeArthur\Adis\Model\VatPayerStatus\Account\Standard\Standard|null
     */
    protected $standard;

    /**
     * @var \LukeArthur\Adis\Model\VatPayerStatus\Account\NonStandard\NonStandard|null
     */
    protected $nonStandard;

    /**
     * @return string|null
     */
    public static function getPropertyName(): ?string
    {
        return 'ucet';
    }

    /**
     * @param \stdClass $response
     * @param array $path
     */
    public function parse(\stdClass $response, array $path = [])
    {
        parent::parse($response, $path);

        if (\property_exists($response, Standard::getPropertyName())) {
            $this->standard = new Standard();
            $this->standard->parse(
                $response->{Standard::getPropertyName()},
                $this->addToPath($path, Standard::getPropertyName())
            );
        } elseif (\property_exists($response, NonStandard::getPropertyName())) {
            $this->nonStandard = new NonStandard();
            $this->nonStandard->parse(
                $response->{NonStandard::getPropertyName()},
                $this->addToPath($path, NonStandard::getPropertyName())
            );
        }
    }

    /**
     * @return \DateTime
     */
    public function getDateOfPublishing(): \DateTime
    {
        return $this->dateOfPublishing;
    }

    /**
     * @return \LukeArthur\Adis\Model\VatPayerStatus\Account\Standard\Standard|null
     */
    public function getStandard(): ?Standard
    {
        return $this->standard;
    }

    /**
     * @return \LukeArthur\Adis\Model\VatPayerStatus\Account\NonStandard\NonStandard|null
     */
    public function getNonStandard(): ?NonStandard
    {
        return $this->nonStandard;
    }

    /**
     * @return bool
     */
    public function isStandard(): bool
    {
        return ($this->standard !== null);
    }
}
