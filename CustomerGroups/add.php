<?php
require_once '../Database.php';
require_once 'CustomerGroups.php';

$db = (new Database())->connect();
$customerGroupModel = new CustomerGroups($db);
$isEdit = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['customer_group']) && is_array($_POST['customer_group'])) {
        foreach ($_POST['customer_group'] as $key => $value) { $customerGroupModel->value($key, $value);
        }
    }
    
    if ($customerGroupModel->save()) {
        header("Location: list.php?message=Saved successfully");
        exit;
    } else {
        header("Location: form.php?error=Failed to save customer group.");
        exit;
    }
}

header("Location: form.php");
exit;
?>
