<?php
require_once "Product.php";

class ListProduct
{
    public function showList()
    {
        $products = $this->fetchProducts();
        $this->render($products);
    }

    private function fetchProducts()
    {
        $db = new Database();
        $db->connect();
        return $db->fetchAll("SELECT * FROM product ORDER BY product_id DESC");
    }

    private function render($products)
    {
        $error = null;
        include "grid.html";
    }
}

$list = new ListProduct();
$list->showList();
?>
