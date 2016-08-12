<?php

namespace Products;

require_once("Product.php");

/**
 * User: vnilov
 * Date: 8/12/16
 */
class ProductsAPI extends Product
{

    // just for an example
    public static $products = [
        ['price' => 10, 'name' => "bike", 'description' => "this is the best bike", 'img' => 'bike.jpg'],
        ['price' => 11, 'name' => "bike1", 'description' => "this is the best bike1", 'img' => 'bike1.jpg'],
    ];

    // CRUD OPERATIONS

    // create
    static function add($data)
    {
        // create product object
        $product = new Product($data);

        //save to "DB"
        static::$products[] = ['price' => $product->price, 'name' => $product->name, 'description' => $product->description, 'img' => $product->img];

        return count(static::$products) - 1;
    }

    // read 
    static function get($id)
    {
        if (array_key_exists($id, static::$products)) {
            $product = new Product(static::$products[$id]);
            return $product->getFields();
        }
    }

    // update
    static function update($data)
    {
        if (isset($data['id'])) {
            $product = static::get($data['id']);
            if (is_array($product)) {
                foreach ($product as $field => $value) {
                    if (isset($data[$field])) {
                        $product[$field] = $data[$field];
                    }
                }
                // safe 2 DB
                static::$products[$data['id']] = $product;

                return true;
            }
        }
    }

    // delete
    static function delete($id)
    {
        if (array_key_exists($id, static::$products)) {
            unset(static::$products[$id]);
            return true;
        }
    }

    // get all 
    static function getAll()
    {
        return static::$products;
    }
}