<?php

require_once('../../Products/ProductsAPI.php');

use \Products\ProductsAPI;

/**
 * User: vnilov
 * Date: 8/12/16
 */
class ProductsAPITest extends PHPUnit_Framework_TestCase
{

    function setUp()
    {
        ProductsAPI::$products = [
            ['price' => 10, 'name' => "bike", 'description' => "this is the best bike", 'img' => 'bike.jpg'],
            ['price' => 15, 'name' => "motobike", 'description' => "Kawasaki S500", 'img' => 'moto1.jpg'],
            ['price' => 20, 'name' => "an apple", 'description' => "fresh fruit", 'img' => 'apple_12.jpg']
        ];
    }

    private $test_id = 2;
    private $data = ['price' => "30", 'name' => "new bike", 'description' => "I don't know what I need to write here", 'img' => "/1.gif"];

    function testGetAll()
    {
        $products = ProductsAPI::getAll();
        foreach ($products as $product) {
            $this->assertArrayHasKey('price', $product);
            $this->assertArrayHasKey('name', $product);
            $this->assertArrayHasKey('description', $product);
            $this->assertArrayHasKey('img', $product);
        }
    }

    function testGet()
    {
        $result = ProductsAPI::get($this->test_id);


        $this->assertArrayHasKey('price', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('description', $result);
        $this->assertArrayHasKey('img', $result);

        $this->assertEquals('an apple', $result['name']);
        $this->assertEquals('20', $result['price']);
        

    }

    function testAdd()
    {
        $result = ProductsAPI::add($this->data);
        $this->assertGreaterThan(2, $result);

        unset($this->data['price']);

        try {
            ProductsAPI::add($this->data);
        } catch (\Exception $e) {
            return true;
        }
        $this->fail("Expected required fields error");
    }

    function testUpdate()
    {
        $this->data['id'] = 0;

        $update = ProductsAPI::update($this->data);

        $this->assertTrue($update);

        $new_product = ProductsAPI::get($this->data['id']);

        $this->assertEquals('new bike', $new_product['name']);
        $this->assertEquals('30', $new_product['price']);

    }

    function testDelete()
    {
        $del = ProductsAPI::delete($this->test_id);
        $this->assertTrue($del);

        $count = count(ProductsAPI::getAll());
        $this->assertEquals('2', $count);
    }
}