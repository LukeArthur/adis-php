<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Model\VatPayerStatus;

use LukeArthur\Adis\Model\VatPayerStatus\Address\Address;

/**
 * VatPayerStatusExtended section
 * property statusPlatceDPH
 * occurence: 0+
 *
 * @author LukeArthur
 */
class VatPayerStatusExtended extends VatPayerStatus
{
    /**
     * @var string
     */
    protected $subjectName;

    /**
     * @var \LukeArthur\Adis\Model\VatPayerStatus\Address\Address
     */
    protected $address;

    /**
     * VatPayerStatusExtended constructor.
     */
    public function __construct()
    {
        static::$attributeMap['nazevSubjektu'] = [
            self::MAP_ATTRIBUTE_NAME => 'subjectName',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ];
    }

    /**
     * @param \stdClass $response
     * @param array $path
     */
    public function parse(\stdClass $response, array $path = [])
    {
        parent::parse($response, $path);

        if (\property_exists($response, Address::getPropertyName())) {
            $this->address = new Address();
            $this->address->parse(
                $response->{Address::getPropertyName()},
                $this->addToPath($path, Address::getPropertyName())
            );
        }
    }

    /**
     * @return string|null
     */
    public function getSubjectName(): ?string
    {
        return $this->subjectName;
    }

    /**
     * @return \LukeArthur\Adis\Model\VatPayerStatus\Address\Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }
}
