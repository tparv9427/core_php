<?php
require_once '../Database.php';
require_once 'Product.php';

$db = (new Database())->connect();
$productModel = new Product($db);
$isEdit = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
        $productModel->load($_POST['product_id']);
    }

    if (isset($_POST['product']) && is_array($_POST['product'])) {
        foreach ($_POST['product'] as $key => $value) {
            $productModel->value($key, $value);
        }
    }
    
    if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
        $productModel->data['product_id'] = $_POST['product_id'];
    }

    if ($productModel->save()) {
        header("Location: list.php?message=Updated successfully");
        exit;
    } else {
        header("Location: form.php?id=" . ($_POST['product_id'] ?? '') . "&error=Failed to save product.");
        exit;
    }
}

$id = $_GET['id'] ?? '';
header("Location: form.php?id=$id");
exit;
?>
