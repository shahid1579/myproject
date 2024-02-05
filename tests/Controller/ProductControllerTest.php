<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testGetProducts()
    {
        $client = static::createClient();
        $client->request('GET', '/products');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('products', $responseData);
        $this->assertNotEmpty($responseData['products']);
    }

    public function testGetProduct()
    {
        $client = static::createClient();
        $client->request('GET', '/product/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('product', $responseData);
        $this->assertNotEmpty($responseData['product']);
    }

    public function testGetProductWithInvalidId()
    {
        $client = static::createClient();
        $client->request('GET', '/product/999');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('No product found for this id.', $responseData['message']);
    }
}
