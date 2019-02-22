<?php
declare(strict_types=1);
namespace LukeArthur\Tests\unit\Request\Soap;

use LukeArthur\Adis\Request\Soap\Service;
use LukeArthur\AdisConfigurator;
use LukeArthur\AdisException;

class ServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testValidateTaxIds()
    {
        $service = new Service(new AdisConfigurator());

        $this->tester->expectThrowable(
            new AdisException('Tax id must be numeric, test given'),
            function () use ($service) {
                $service->validateTaxIds(['test']);
            }
        );

        $this->tester->expectThrowable(
            new AdisException('Tax id must have length from 1 to 10, 1234567891011 given with length 13'),
            function () use ($service) {
                $service->validateTaxIds(['1234567891011']);
            }
        );

        $this->tester->expectThrowable(
            new AdisException('Count of tax ids must be between 1 and 100, 101 given'),
            function () use ($service) {
                $ids = [];

                for ($i = 0; $i < 101; $i++) {
                    $ids[] = $i;
                }

                $service->validateTaxIds($ids);
            }
        );

        $this->assertTrue($service->validateTaxIds(['0001234567'], ['12345']));
    }
}
