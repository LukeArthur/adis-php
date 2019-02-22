<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Model;

use LukeArthur\Adis\Model\Status\Status;
use LukeArthur\Adis\Model\VatPayerStatus\VatPayerStatus;

/**
 * UnreliablePayer response parser
 *
 * @author LukeArthur
 */
class UnreliablePayer extends Model
{
    use TUnreliablePayer {
        getVatPayerStatus as getTraitVatPayerStatus;
    }

    /**
     * @param \stdClass $response
     * @param array $path
     */
    public function parse(\stdClass $response, array $path = [])
    {
        parent::parse($response, $path);

        $this->status = new Status();
        $this->status->parse(
            $response->{Status::getPropertyName()},
            $this->addToPath($path, Status::getPropertyName())
        );

        $this->vatPayerStatuses = [];

        if (\property_exists($response, VatPayerStatus::getPropertyName())) {
            if ($response->{VatPayerStatus::getPropertyName()} instanceof \stdClass) {
                $vatPayerStatus = new VatPayerStatus();
                $vatPayerStatus->parse(
                    $response->{VatPayerStatus::getPropertyName()},
                    $this->addToPath($path, VatPayerStatus::getPropertyName())
                );
                $this->vatPayerStatuses[] = $vatPayerStatus;
            } else {
                foreach ($response->{VatPayerStatus::getPropertyName()} as $key => $vatPayerStatusData) {
                    $vatPayerStatus = new VatPayerStatus();
                    $vatPayerStatus->parse(
                        $vatPayerStatusData,
                        $this->addToPath($path, VatPayerStatus::getPropertyName(), $key)
                    );
                    $this->vatPayerStatuses[] = $vatPayerStatus;
                }
            }
        }
    }

    /**
     * @return \LukeArthur\Adis\Model\VatPayerStatus\VatPayerStatus[]
     */
    public function getVatPayerStatuses(): array
    {
        return $this->vatPayerStatuses;
    }

    /**
     * Returns the only VatPayerStatus if there was only one in response or returns VatPayerStatus with given taxId.
     * When no suitable VatPayerStatus exists, returns null.
     * @param string|null $taxId
     * @return \LukeArthur\Adis\Model\VatPayerStatus\VatPayerStatus|null
     */
    public function getVatPayerStatus(string $taxId = null): ?VatPayerStatus
    {
        return $this->getTraitVatPayerStatus($taxId);
    }
}
