<?php
declare(strict_types=1);
namespace LukeArthur\Tests\unit\Model;

use Codeception\Test\Unit;
use LukeArthur\Adis\Model\UnreliablePayer;
use LukeArthur\Adis\Model\VatPayerStatus\VatPayerStatus;

class UnreliablePayerTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testUnreliablePayerResponseOneManyAccounts()
    {
        $payer = new UnreliablePayer();
        $payer->parse($this->tester->readResponse('UPROneManyAccounts.json'));
        $this->assertTrue($payer->getStatus()->isResponseOk());
        $this->assertCount(1, $payer->getVatPayerStatuses());
        $this->assertFalse($payer->getVatPayerStatuses()[0]->isUnreliablePayer());
        $this->assertCount(9, $payer->getVatPayerStatuses()[0]->getPublishedAccounts()->getAccounts());
    }

    public function testUnreliablePayerResponseOneNoAccounts()
    {
        $payer = new UnreliablePayer();
        $payer->parse($this->tester->readResponse('UPROneNoAccounts.json'));
        $this->assertTrue($payer->getStatus()->isResponseOk());
        $this->assertCount(1, $payer->getVatPayerStatuses());
        $this->assertTrue($payer->getVatPayerStatuses()[0]->isUnreliablePayer());
        $this->assertNull($payer->getVatPayerStatuses()[0]->getPublishedAccounts());
    }

    public function testUnreliablePayerVatPayerStatus()
    {
        $payer = new UnreliablePayer();
        $payer->parse($this->tester->readResponse('UPROneNoAccounts.json'));
        $this->assertInstanceOf(VatPayerStatus::class, $payer->getVatPayerStatus());
        $this->assertInstanceOf(VatPayerStatus::class, $payer->getVatPayerStatus("00121100"));
        $this->assertNull($payer->getVatPayerStatus("test"));
    }
}
