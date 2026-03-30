<?php
require_once '../Database.php';
require_once 'ProductMedia.php';

$db = (new Database())->connect();
$productMediaModel = new ProductMedia($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_media_id']) && !empty($_POST['product_media_id'])) {
        $productMediaModel->load($_POST['product_media_id']);
    }

    if (isset($_POST['product_media']) && is_array($_POST['product_media'])) {
        foreach ($_POST['product_media'] as $key => $value) {
            $productMediaModel->value($key, $value);
        }
    }
    
    if (isset($_POST['product_media_id']) && !empty($_POST['product_media_id'])) {
        $productMediaModel->data['product_media_id'] = $_POST['product_media_id'];
    }

    if ($productMediaModel->save()) {
        header("Location: list.php?message=Media updated successfully");
        exit;
    } else {
        header("Location: form.php?id=" . ($_POST['product_media_id'] ?? '') . "&error=Failed to update product media.");
        exit;
    }
}

$id = $_GET['id'] ?? '';
header("Location: form.php?id=$id");
exit;
?>
