<?php
require_once '../Database.php';
require_once 'Category.php';

$db = (new Database())->connect();
$categoryModel = new Category($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = $_POST['category_id'] ?? null;
    
    if ($categoryId) {
        $categoryModel->load($categoryId);
    }

    if (isset($_POST['category']) && is_array($_POST['category'])) {
        foreach ($_POST['category'] as $key => $value) {
            $categoryModel->value($key, $value);
        }
    }
    
    // Ensure ID is set for update
    if ($categoryId) {
        $categoryModel->value('category_id', $categoryId);
    }

    if ($categoryModel->save()) {
        $message = $categoryId ? "updated" : "created";
        header("Location: list.php?message=Category $message successfully");
        exit;
    } else {
        header("Location: form.php?id=$categoryId&error=No changes made or update failed.");
        exit;
    }
}

header("Location: list.php");
exit;
?>
