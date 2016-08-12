<?php

namespace Products;
/**
 * User: vnilov
 * Date: 8/12/16
 */
class Product
{
    // some product fields
    protected $price = 0;
    protected $name = "";
    protected $description = "";
    protected $img = "";
    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img)
    {
        $this->img = $img;
    }




    protected function __construct($data)
    {

        if (static::checkInputData($data)) {

            $this->price = $data['price'];
            $this->name = $data['name'];
            $this->description = $data['description'];
            $this->img = $data['img'];

        }
    }

    protected static function checkInputData($data)
    {
        if (isset($data['price']) &&
            isset($data['name']) &&
            isset($data['description']) &&
            isset($data['img'])
        ) {
            return true;
        } else {
            throw new \Exception("Error. There aren't all required fields");
        }
    }

    protected function getFields()
    {
        return get_object_vars($this);
    }

}