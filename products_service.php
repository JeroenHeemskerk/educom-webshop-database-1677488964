<?php

function getWebshopProducts()
{
    $products = array();
    $genericErr = "";
    try {
        $products = getAllProducts();
    } catch (Exception $e) {
        $genericErr = "Sorry, cannot show products at this moment.";
        debug_to_console("GetAllProducts failed  " . $e->getMessage());
    }
    return array("products" => $products, "genericErr" => $genericErr);
}

function getProductDetails($productId)
{
    $product = array();
    $genericErr = "";
    try {
        $product = findProductById($productId);
    } catch (Exception $e) {
        $genericErr = "Sorry, cannot show details at this moment.";
        debug_to_console("findProductById failed  " . $e->getMessage());
    }
    return array("product" => $product, "genericErr" => $genericErr);
}
