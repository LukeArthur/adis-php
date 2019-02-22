<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Model;

use LukeArthur\Adis\Model\Status\Status;
use LukeArthur\Adis\Model\VatPayerStatus\VatPayerStatusExtended;

/**
 * UnreliablePayerExtended response parser
 *
 * @author LukeArthur
 */
/* Can't extend UnreliablePayer because of parse method.
 Need to call parse from parent (Model) but not from UnreliablePayer.
*/
class UnreliablePayerExtended extends Model
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

        if (\property_exists($response, VatPayerStatusExtended::getPropertyName())) {
            if ($response->{VatPayerStatusExtended::getPropertyName()} instanceof \stdClass) {
                $vatPayerStatus = new VatPayerStatusExtended();
                $vatPayerStatus->parse(
                    $response->{VatPayerStatusExtended::getPropertyName()},
                    $this->addToPath($path, VatPayerStatusExtended::getPropertyName())
                );
                $this->vatPayerStatuses[] = $vatPayerStatus;
            } else {
                foreach ($response->{VatPayerStatusExtended::getPropertyName()} as $key => $vatPayerStatusData) {
                    $vatPayerStatus = new VatPayerStatusExtended();
                    $vatPayerStatus->parse(
                        $vatPayerStatusData,
                        $this->addToPath($newPath = $path, VatPayerStatusExtended::getPropertyName(), $key)
                    );
                    $this->vatPayerStatuses[] = $vatPayerStatus;
                }
            }
        }
    }

    /**
     * @return \LukeArthur\Adis\Model\VatPayerStatus\VatPayerStatusExtended[]
     */
    public function getVatPayerStatuses(): array
    {
        return $this->vatPayerStatuses;
    }

    /**
     * Returns the only VatPayerStatus if there was only one in response or returns VatPayerStatus with given taxId.
     * When no suitable VatPayerStatus exists, returns null.
     * @param string|null $taxId
     * @return \LukeArthur\Adis\Model\VatPayerStatus\VatPayerStatusExtended|null
     */
    public function getVatPayerStatus(string $taxId = null): ?VatPayerStatusExtended
    {
        return $this->getTraitVatPayerStatus($taxId);
    }
}
