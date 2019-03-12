<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Request\Soap;

use LukeArthur\AdisConfigurator;
use LukeArthur\AdisException;

/**
 * ADIS soap request service
 *
 * @author LukeArthur
 */
class Service
{
    /**
     * @var AdisConfigurator
     */
    protected $configurator;

    /**
     * @var \SoapClient
     */
    protected $soapClient;

    /**
     * @param \LukeArthur\AdisConfigurator $configurator
     */
    public function __construct(AdisConfigurator $configurator)
    {
        $this->configurator = $configurator;
    }

    /**
     * @return \LukeArthur\AdisConfigurator
     */
    protected function getConfigurator(): AdisConfigurator
    {
        return $this->configurator;
    }

    /**
     * @return \SoapClient
     */
    protected function getSoapClient(): \SoapClient
    {
        return ($this->soapClient !== null)
            ? $this->soapClient
            : new \SoapClient($this->getConfigurator()->getWsdlUrl(), ['trace' => 1]);
    }

    /**
     * Do general soap call to ADIS. No parameter validation included.
     *
     * @internal
     * @param string $functionName
     * @param array $arguments
     * @return mixed
     * @throws \LukeArthur\AdisException
     */
    public function doSoapCall(string $functionName, array $arguments = [])
    {
        $soapClient = $this->getSoapClient();

        try {
            $response = $soapClient->__soapCall($functionName, $arguments);
        } catch (\Exception $ex) {
            throw new AdisException($soapClient->__getLastResponse(), $ex->getCode(), $ex);
        }

        return $response;
    }

    /**
     * Unreliable payer status request
     *
     * @param array $taxIds
     * @return mixed
     * @throws \LukeArthur\AdisException
     */
    public function unrealiablePayerStatus(array $taxIds)
    {
        $this->validateTaxIds($taxIds);
        $configurator = $this->getConfigurator();

        return $this->doSoapCall(
            $configurator->getMethodNameForUnreliablePayerStatus(),
            [$configurator->getRequestParameterNameForTaxId() => $taxIds]
        );
    }

    /**
     * Unrealiable payer extended status request
     *
     * @param array $taxIds
     * @return mixed
     * @throws \LukeArthur\AdisException
     */
    public function unreliablePayerExtendedStatus(array $taxIds)
    {
        $this->validateTaxIds($taxIds);
        $configurator = $this->getConfigurator();

        return $this->doSoapCall(
            $configurator->getMethodNameForUnreliablePayerExtendedStatus(),
            [$configurator->getRequestParameterNameForTaxId() => $taxIds]
        );
    }

    /**
     * TaxIds parameter validation.
     *
     * @param array $taxIds
     * @return bool
     * @throws \LukeArthur\AdisException
     */
    public function validateTaxIds(array $taxIds): bool
    {
        $configurator = $this->getConfigurator();
        $count = \count($taxIds);

        if ($count < $configurator->getMinTaxIds() || $count > $configurator->getMaxTaxIds()) {
            throw new AdisException(
                \sprintf(
                    'Count of tax ids must be between %d and %d, %d given',
                    $configurator->getMinTaxIds(),
                    $configurator->getMaxTaxIds(),
                    $count
                )
            );
        }

        foreach ($taxIds as $taxId) {
            if (!\is_numeric($taxId)) {
                throw new AdisException(\sprintf('Tax id must be numeric, %s given', $taxId));
            }

            $length = \strlen($taxId);

            if ($length < $configurator->getMinTaxIdLength() || $length > $configurator->getMaxTaxIdLength()) {
                throw new AdisException(
                    \sprintf(
                        'Tax id must have length from %d to %d, %s given with length %d',
                        $configurator->getMinTaxIdLength(),
                        $configurator->getMaxTaxIdLength(),
                        $taxId,
                        $length
                    )
                );
            }
        }

        return true;
    }

    /**
     * Unreliable payer list request
     *
     * @return mixed
     * @throws \LukeArthur\AdisException
     */
    public function unreliablePayerList()
    {
        return $this->doSoapCall($this->getConfigurator()->getMethodNameForUnreliablePayerList());
    }
}
