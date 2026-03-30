<?php
require_once '../Database.php';
require_once 'CustomerGroups.php';

$db = (new Database())->connect();
$customerGroupModel = new CustomerGroups($db);
$isEdit = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['customer_group_id']) && !empty($_POST['customer_group_id'])) {
        $customerGroupModel->load($_POST['customer_group_id']);
    }

    if (isset($_POST['customer_group']) && is_array($_POST['customer_group'])) {
        foreach ($_POST['customer_group'] as $key => $value) {
            $customerGroupModel->value($key, $value);
        }
    }
    
    if (isset($_POST['customer_group_id']) && !empty($_POST['customer_group_id'])) {
        $customerGroupModel->data['customer_group_id'] = $_POST['customer_group_id'];
    }

    if ($customerGroupModel->save()) {
        header("Location: list.php?message=Updated successfully");
        exit;
    } else {
        header("Location: form.php?id=" . ($_POST['customer_group_id'] ?? '') . "&error=Failed to save customer group.");
        exit;
    }
}

$id = $_GET['id'] ?? '';
header("Location: form.php?id=$id");
exit;
?>
