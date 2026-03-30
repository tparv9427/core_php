<?php
require_once '../Database.php';
require_once 'Customers.php';

$db = (new Database())->connect();
$customerModel = new Customers($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['customer']) && is_array($_POST['customer'])) {
        foreach ($_POST['customer'] as $key => $value) {
            $customerModel->value($key, $value);
        }
    }
    
    if ($customerModel->save()) {
        header("Location: list.php?message=Saved successfully");
        exit;
    } else {
        header("Location: form.php?error=Failed to save customer.");
        exit;
    }
}

header("Location: form.php");
exit;
?>
