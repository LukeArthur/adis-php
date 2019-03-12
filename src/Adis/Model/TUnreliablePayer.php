<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Model;

use LukeArthur\Adis\Model\Status\Status;

trait TUnreliablePayer
{
    /**
     * @var \LukeArthur\Adis\Model\Status\Status
     */
    protected $status;

    /**
     * @var \LukeArthur\Adis\Model\VatPayerStatus\VatPayerStatus[]
     */
    protected $vatPayerStatuses;

    /**
     * @return string|null
     */
    public static function getPropertyName(): ?string
    {
        return null;
    }

    /**
     * @return \LukeArthur\Adis\Model\Status\Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    protected function getVatPayerStatus(string $taxId = null)
    {
        $vatPayerStatus = null;

        if (null === $taxId && \count($this->vatPayerStatuses) === 1) {
            $vatPayerStatus = \reset($this->vatPayerStatuses);
        } else {
            foreach ($this->vatPayerStatuses as $status) {
                if ($status->getTaxId() === $taxId) {
                    $vatPayerStatus = $status;
                    break;
                }
            }
        }

        return $vatPayerStatus;
    }
}
