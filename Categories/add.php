<?php
require_once '../Database.php';
require_once 'Category.php';

$db = (new Database())->connect();
$categoryModel = new Category($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['category']) && is_array($_POST['category'])) {
        foreach ($_POST['category'] as $key => $value) { 
            $categoryModel->value($key, $value);
        }
    }
    
    if ($categoryModel->save()) {
        header("Location: list.php?message=Category created successfully");
        exit;
    } else {
        header("Location: form.php?error=Failed to save category.");
        exit;
    }
}

header("Location: form.php");
exit;
?>
