<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    public function testOrderWithValidProduct()
    {
        $client = static::createClient();

        $client->request('POST', '/order', [
            'product_id' => 1,
            'quantity' => 2,
        ]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"order":"Your order has been placed."}', $client->getResponse()->getContent());
    }

    public function testOrderWithInvalidProduct()
    {
        $client = static::createClient();

        $client->request('POST', '/order', [
            'product_id' => 999,
            'quantity' => 1,
        ]);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"error":"Product not found."}', $client->getResponse()->getContent());
    }

    public function testOrderWithOutOfStockProduct()
    {
        $client = static::createClient();

        $client->request('POST', '/order', [
            'product_id' => 2,
            'quantity' => 59,
        ]);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"error":"Product out of stock."}', $client->getResponse()->getContent());
    }
}
