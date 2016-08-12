<?php
/**
 * User: vnilov
 * Date: 8/12/16
 */

require_once "ProductsController.php";

$controller = new ProductsController($_SERVER);

$controller->run();