<?php
namespace Tests\Unit;

use Bmatovu\MtnMomo\Exceptions\CollectionRequestException;
use Bmatovu\MtnMomo\Products\Collection;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class MomoTest extends TestCase
{
    public function testRequestToPay() {
        try {
            $collection = new Collection();

            $momoTransactionId = $collection->requestToPay('bfab46d9-0c63-4eaf-8eea-c5fc47a8e8ef', '0248888736', 250);
            $this->assertTrue(Uuid::isValid($momoTransactionId));

            $result = $collection->getTransactionStatus($momoTransactionId);
            print_r($result);

            echo $result['financialTransactionId'];
            echo $result['payer']['partyId'];
            
            // expired, see /api-documentation/testing/
            $momoTransactionId = $collection->requestToPay('bfab46d9-0c63-4eaf-8eea-c5fc47a8e8ef', '46733123452', 150);
            $this->assertTrue(Uuid::isValid($momoTransactionId));

            $result = $collection->getTransactionStatus($momoTransactionId);
            print_r($result);
            
        } catch (CollectionRequestException $e) {
            do {
                printf("\n\r%s:%d %s (%d) [%s]\n\r", $e->getFile(), $e->getLine(), $e->getMessage(), $e->getCode(),
                    get_class($e));
            } while ($e = $e->getPrevious());
        }
    }

    public function testCheckActiveParty() {
        try {
            $collection = new Collection();
            $result = $collection->isActive('0248888736');

            $this->assertTrue($result);
        } catch (CollectionRequestException $e) {
            do {
                printf("\n\r%s:%d %s (%d) [%s]\n\r", $e->getFile(), $e->getLine(), $e->getMessage(), $e->getCode(),
                    get_class($e));
            } while ($e = $e->getPrevious());
        }
    }

    public function testGetBalance() {
        try {
            $collection = new Collection();
            $result = $collection->getAccountBalance();

            $this->assertTrue(sizeof($result) > 0);
            print_r($result);
        } catch (CollectionRequestException $e) {
            do {
                printf("\n\r%s:%d %s (%d) [%s]\n\r", $e->getFile(), $e->getLine(), $e->getMessage(), $e->getCode(),
                    get_class($e));
            } while ($e = $e->getPrevious());
        }
    }

    public function testGetToken() {
        try {
            $collection = new Collection();
            $result = $collection->getToken();

            $this->assertTrue(sizeof($result) > 0);
            print_r($result);
        } catch (CollectionRequestException $e) {
            do {
                printf("\n\r%s:%d %s (%d) [%s]\n\r", $e->getFile(), $e->getLine(), $e->getMessage(), $e->getCode(),
                    get_class($e));
            } while ($e = $e->getPrevious());
        }
    }
}
