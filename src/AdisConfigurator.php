<?php
declare(strict_types=1);
namespace LukeArthur;

/**
 * Configures ADIS requests and validation checks.
 * In need of configuration you can extend this class and override what you need.
 *
 * @author LukeArthur
 */
class AdisConfigurator
{
    protected static $wsdlUrl = 'http://adisrws.mfcr.cz/adistc/axis2/services/rozhraniCRPDPH.rozhraniCRPDPHSOAP?wsdl';
    protected static $targetNamespace = 'http://adis.mfcr.cz/rozhraniCRPDPH/';

    protected static $methodNameForUnreliablePayerStatus = 'getStatusNespolehlivyPlatce';
    protected static $methodNameForUnreliablePayerExtendedStatus = 'getStatusNespolehlivyPlatceRozsireny';
    protected static $methodNameForUnreliablePayerList = 'getSeznamNespolehlivyPlatce';

    protected static $requestParameterNameForTaxId = 'dic';

    protected static $minTaxIds = 1;
    protected static $maxTaxIds = 100;

    protected static $minTaxIdLength = 1;
    protected static $maxTaxIdLength = 10;

    /**
     * @return string
     */
    public function getWsdlUrl(): string
    {
        return static::$wsdlUrl;
    }

    /**
     * @return string
     */
    public function getTargetNamespace(): string
    {
        return static::$targetNamespace;
    }

    /**
     * @return string
     */
    public function getMethodNameForUnreliablePayerStatus(): string
    {
        return static::$methodNameForUnreliablePayerStatus;
    }

    /**
     * @return string
     */
    public function getMethodNameForUnreliablePayerExtendedStatus(): string
    {
        return static::$methodNameForUnreliablePayerExtendedStatus;
    }

    /**
     * @return string
     */
    public function getMethodNameForUnreliablePayerList(): string
    {
        return static::$methodNameForUnreliablePayerList;
    }

    /**
     * @return string
     */
    public function getRequestParameterNameForTaxId(): string
    {
        return static::$requestParameterNameForTaxId;
    }

    /**
     * @return int
     */
    public function getMinTaxIds(): int
    {
        return static::$minTaxIds;
    }

    /**
     * @return int
     */
    public function getMaxTaxIds(): int
    {
        return static::$maxTaxIds;
    }

    /**
     * @return int
     */
    public function getMinTaxIdLength(): int
    {
        return static::$minTaxIdLength;
    }

    /**
     * @return int
     */
    public function getMaxTaxIdLength(): int
    {
        return static::$maxTaxIdLength;
    }
}
