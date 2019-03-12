# adis-php
This service allows to read information about unreliable payers and more from ADIS (automatized tax information system run by financial management of Czech Republic). You can find more on this url (in czech): https://adisepo.mfcr.cz/adistc/adis/idpr_pub/dpr_info/ws_spdph.faces

#Usage
Use class LukeArthur\Adis. It includes methods for data retrieval from ADIS via SOAP (do... methods) and response parsing (parse... methods). It is divided into these two parts so you can cache responses or parse them yourself if you need one specific information etc.

Request returns \stdClass object with data from ADIS. If you want to have it parsed into predefined models, use parse method for type of request you called.

Within response - depending on your type of request - you can find if subject with given tax ID is reliable payer, published bank accounts and even address. Check out models if you want to know more.
##Examples
###Doing request and parsing response
```
<?php
$adis = new \LukeArthur\Adis();
try {
    $response = $adis->doUnreliablePayerStatusRequest(["1111111111", "2222222222"]);
    $parsedResponse = $adis->parseUnreliablePayerStatusResponse($response);
} catch (\LukeArthur\AdisException $exception) {
    // something went wrong
}
```
###Finding out if response was OK
```
$parsedResponse->getStatus()->isResponseOk();
```
You can also use getCode() method for more informative answer.

Status codes:
- CODE_OK: Response is correct.
- CODE_OK_ONLY_HUNDRED: Response is correct but only partial because request had more than 100 tax ids. In this case method isResponseOk() will return false. It shouldn't happen with basic configuration and tax ids validation because AdisException will be thrown before request.
- CODE_TECHNICAL_SHUTDOWN: Service is temporarily unavailable due to maintenance.
- CODE_SERVICE_UNAVAILABLE: Service is unavailable.

###Finding out if subject is unreliable payer
```
foreach ($parsedResponse->getVatPayerStatuses() as $vatPayerStatus) {
    $taxId = $vatPayerStatus->getTaxId();
    $isUnreliablePayer = $vatPayerStatus->isUnreliablePayer();
    $isReliablePayer = $vatPayerStatus->isReliablePayer();
}
```
You can also use getUnreliablePayer() method.

Unreliable payer codes:
- UNRELIABLE_PAYER_YES: Payer is unreliable.
- UNRELIABLE_PAYER_NO: Payer is reliable.
- UNRELIABLE_PAYER_NOT_FOUND: Payer with given tax id wasn't found so reliability couldn't be determined. Both methods isUnreliablePayer() and isReliablePayer() return false.
###Getting specific vat payer from response
If response has only one vat payer, you don't have to do foreach on method getVatPayerStatuses(), you can use:
```
$parsedResponse->getVatPayerStatus();
```
If response has more than one vat payer and you know his tax ID (like 1111111111), you can use:
```
$parsedResponse->getVatPayerStatus("1111111111");
```
When specific vat payer isn't found, method getVatPayerStatus() returns null.
###Getting list of all unreliable payers
```
$response = $adis->doUnreliablePayerListRequest();
$parsedResponse = $adis->parseUnreliablePayerListResponse($response);
foreach ($parsedResponse->getVatPayerStatuses() as $vatPayerStatus) {
    $taxId = $vatPayerStatus->getTaxId();
}
```
Note: This request isn't limited by 100 tax ids like other request types. It returns all unreliable payers at once.