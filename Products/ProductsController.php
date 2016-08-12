<?php

require_once "ProductsAPI.php";

use Products\ProductsAPI;

/**
 * User: vnilov
 * Date: 8/12/16
 */
class ProductsController
{
    private $contentType;
    private $method = "GET";
    private $params = [];

    function __construct($server)
    {
        $this->contentType = ($server['HTTP_ACCEPT'] == "application/xml") ? "application/xml" : "application/json";
        $this->params = array_filter(explode("/", $server['REQUEST_URI']), array($this, "myFilter"));
        if (isset($server['REQUEST_METHOD'])) {
            $this->method = $server['REQUEST_METHOD'];
        }
       // var_dump($server);
    }

    private function responseJSON($data)
    {
        return json_encode($data);
    }

    private function responseXML($data)
    {
        // TODO: implement this type of response
    }

    private function setHttpHeaders(){
        header("Content-Type:". $this->contentType);
    }
    
    function run()
    {
        $code = 200;
        $count = count($this->params);
        if ($count == 1) {
            if ($this->method == "PUT") {
                    parse_str(file_get_contents('php://input'), $data_array);
                    $response = ProductsAPI::add($data_array);
                    if ($response >= 0) {
                        $code = 201;
                    }
            } else {
               $response = ProductsAPI::getAll();
            }
        } elseif ($count == 2) {
            $id = array_pop($this->params);
            switch ($this->method) {
                case "DELETE":
                    if (!($response = ProductsAPI::delete($id)))
                        $code = 404;
                    break;
                case "POST":
                    parse_str(file_get_contents('php://input'), $data_array);
                    $data_array['id'] = $id;
                    if (!($response = ProductsAPI::update($data_array)))
                        $code = 404;
                    break;
                default:
                    $response = ProductsAPI::get($id);
                    if (!is_array($response))
                        $code = 404;
                    break;
            }
        } else {
            throw new \Exception("Bad Request");
        }

        $this->setHttpHeaders();
        http_response_code($code);
        if ($this->contentType == "application/json") {
            echo $this->responseJSON($response);
        } else {
            echo $this->responseXML($response);
        }
        unset($code, $count, $response);
    }
    
    private function myFilter($var) {
        return ($var !== "");
    }
}