<?php
declare(strict_types=1);
namespace LukeArthur\Tests\unit\Model;

use Codeception\Test\Unit;
use LukeArthur\Adis\Model\UnreliablePayerList;

class UnreliablePayerListTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testUnreliablePayerListResponse()
    {
        $payer = new UnreliablePayerList();
        $payer->parse($this->tester->readResponse('UPLR.json'));
        $this->assertTrue($payer->getStatus()->isResponseOk());
        $this->assertCount(8135, $payer->getVatPayerStatuses());
    }

    public function testUnreliablePayerListResponseNoPayers()
    {
        $payer = new UnreliablePayerList();
        $payer->parse($this->tester->readResponse('UPLRNoPayers.json'));
        $this->assertTrue($payer->getStatus()->isResponseOk());
        $this->assertCount(0, $payer->getVatPayerStatuses());
    }
}
