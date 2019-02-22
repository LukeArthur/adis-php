<?php
declare(strict_types=1);
namespace LukeArthur\Tests\unit\Model;

use Codeception\Test\Unit;
use LukeArthur\Adis\Model\UnreliablePayerExtended;
use LukeArthur\Adis\Model\VatPayerStatus\VatPayerStatusExtended;

class UnreliablePayerExtendedTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testUnreliablePayerExtendedResponseMany()
    {
        $payer = new UnreliablePayerExtended();
        $payer->parse($this->tester->readResponse('UPERMany.json'));
        $this->assertTrue($payer->getStatus()->isResponseOk());
        $this->assertCount(2, $payer->getVatPayerStatuses());
    }

    public function testUnreliablePayerExtendedVatPayerStatus()
    {
        $payer = new UnreliablePayerExtended();
        $payer->parse($this->tester->readResponse('UPERMany.json'));
        $this->assertInstanceOf(VatPayerStatusExtended::class, $payer->getVatPayerStatus("05117399"));
        $this->assertInstanceOf(VatPayerStatusExtended::class, $payer->getVatPayerStatus("26168685"));
        $this->assertNull($payer->getVatPayerStatus(null));
        $this->assertNull($payer->getVatPayerStatus(("test")));
    }

    public function testUnreliablePayerExtendedResponseOneOneAccount()
    {
        $payer = new UnreliablePayerExtended();
        $payer->parse($this->tester->readResponse('UPEROneOneAccount.json'));
        $this->assertTrue($payer->getStatus()->isResponseOk());
        $this->assertCount(1, $payer->getVatPayerStatuses());
        $this->assertCount(1, $payer->getVatPayerStatuses()[0]->getPublishedAccounts()->getAccounts());
    }
}
