<?php
namespace LukeArthur;

use LukeArthur\Adis\Model\UnreliablePayer;
use LukeArthur\Adis\Model\UnreliablePayerExtended;
use LukeArthur\Adis\Model\UnreliablePayerList;
use LukeArthur\Adis\Request\Soap\Service;

/**
 * ADIS control class. Use it for everything you need to do.
 *
 * @author LukeArthur
 */
class Adis
{
    /**
     * @var \LukeArthur\Adis\Request\Soap\Service
     */
    protected $service;

    /**
     * @var \LukeArthur\AdisConfigurator
     */
    protected $configurator;

    /**
     * ADIS constructor.
     * If you want to configure ADIS, use configurator parameter. Otherwise basic configuration will be used.
     *
     * @param \LukeArthur\AdisConfigurator|null $configurator
     */
    public function __construct(AdisConfigurator $configurator = null)
    {
        $this->configurator = ($configurator === null) ? new AdisConfigurator(): $configurator;
    }

    /**
     * @return \LukeArthur\AdisConfigurator
     */
    protected function getConfigurator(): AdisConfigurator
    {
        return $this->configurator;
    }

    /**
     * @return \LukeArthur\Adis\Request\Soap\Service
     */
    protected function getService()
    {
        return ($this->service === null) ? new Service($this->getConfigurator()) : $this->service;
    }

    /**
     * Does unreliable payer status request to ADIS. Don't use CZ prefix with taxIds.
     * @param array $taxIds
     * @return \stdClass
     * @throws \LukeArthur\AdisException
     */
    public function doUnreliablePayerStatusRequest(array $taxIds)
    {
        return $this->getService()->unrealiablePayerStatus($taxIds);
    }

    /**
     * Parses unreliable payer response into models.
     * @param \stdClass $response
     * @return \LukeArthur\Adis\Model\UnreliablePayer
     */
    public function parseUnreliablePayerStatusResponse(\stdClass $response)
    {
        $parsedResponse = new UnreliablePayer();
        $parsedResponse->parse($response);

        return $parsedResponse;
    }

    /**
     * Does unreliable payer extended status request to ADIS. Don't use CZ prefix with taxIds.
     * @param array $taxIds
     * @return \stdClass
     * @throws \LukeArthur\AdisException
     */
    public function doUnreliablePayerExtendedStatusRequest(array $taxIds)
    {
        return $this->getService()->unreliablePayerExtendedStatus($taxIds);
    }

    /**
     * Parses unreliable payer extended response into models.
     * @param \stdClass $response
     * @return \LukeArthur\Adis\Model\UnreliablePayerExtended
     */
    public function parseUnreliablePayerExtendedStatusResponse(\stdClass $response)
    {
        $parsedResponse = new UnreliablePayerExtended();
        $parsedResponse->parse($response);

        return $parsedResponse;
    }

    /**
     * Does unreliable payer list request to ADIS.
     * @return \stdClass
     * @throws \LukeArthur\AdisException
     */
    public function doUnreliablePayerListRequest()
    {
        return $this->getService()->unreliablePayerList();
    }

    /**
     * Parses unreliable payer list response into models.
     * @param \stdClass $response
     * @return \LukeArthur\Adis\Model\UnreliablePayerList
     */
    public function parseUnreliablePayerListResponse(\stdClass $response)
    {
        $parseResponse = new UnreliablePayerList();
        $parseResponse->parse($response);

        return $parseResponse;
    }

}
