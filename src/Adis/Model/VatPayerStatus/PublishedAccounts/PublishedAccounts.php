<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Model\VatPayerStatus\PublishedAccounts;

use LukeArthur\Adis\Model\Model;
use LukeArthur\Adis\Model\VatPayerStatus\Account\Account;

/**
 * PublishedAccounts section
 * property: zverejneneUcty
 * occurence: 0|1
 *
 * @author LukeArthur
 */
class PublishedAccounts extends Model
{
    /**
     * @var \LukeArthur\Adis\Model\VatPayerStatus\Account\Account[]
     */
    protected $accounts;

    /**
     * @return string|null
     */
    public static function getPropertyName(): ?string
    {
        return 'zverejneneUcty';
    }

    /**
     * @param \stdClass $response
     * @param array $path
     */
    public function parse(\stdClass $response, array $path = [])
    {
        parent::parse($response, $path);

        $this->accounts = [];

        if ($response->{Account::getPropertyName()} instanceof \stdClass) {
            $account = new Account();
            $account->parse(
                $response->{Account::getPropertyName()},
                $this->addToPath($path, Account::getPropertyName())
            );
            $this->accounts[] = $account;
        } else {
            foreach ($response->{Account::getPropertyName()} as $key => $accountData) {
                $account = new Account();
                $account->parse(
                    $accountData,
                    $this->addToPath($path, Account::getPropertyName(), $key)
                );
                $this->accounts[] = $account;
            }
        }
    }

    /**
     * @return \LukeArthur\Adis\Model\VatPayerStatus\Account\Account[]
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }
}
