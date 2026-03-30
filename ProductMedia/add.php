<?php
require_once '../Database.php';
require_once 'ProductMedia.php';

$db = (new Database())->connect();
$productMediaModel = new ProductMedia($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_media']) && is_array($_POST['product_media'])) {
        foreach ($_POST['product_media'] as $key => $value) {
            $productMediaModel->value($key, $value);
        }
    }
    
    if ($productMediaModel->save()) {
        header("Location: list.php?message=Media saved successfully");
        exit;
    } else {
        header("Location: form.php?error=Failed to save product media.");
        exit;
    }
}

header("Location: form.php");
exit;
?>
