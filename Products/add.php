<?php
require_once '../Database.php';
require_once 'Product.php';

$db = (new Database())->connect();
$productModel = new Product($db);
$isEdit = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product']) && is_array($_POST['product'])) {
        foreach ($_POST['product'] as $key => $value) {
            $productModel->value($key, $value);
        }
    }
    
    if ($productModel->save()) {
        header("Location: list.php?message=Saved successfully");
        exit;
    } else {
        header("Location: form.php?error=Failed to save product.");
        exit;
    }
}

header("Location: form.php");
exit;
?>
