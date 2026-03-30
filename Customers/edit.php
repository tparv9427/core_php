<?php
require_once '../Database.php';
require_once 'Customers.php';

$db = (new Database())->connect();
$customerModel = new Customers($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['customer_id']) && !empty($_POST['customer_id'])) {
        $customerModel->load($_POST['customer_id']);
    }

    if (isset($_POST['customer']) && is_array($_POST['customer'])) {
        foreach ($_POST['customer'] as $key => $value) {
            $customerModel->value($key, $value);
        }
    }
    
    if (isset($_POST['customer_id']) && !empty($_POST['customer_id'])) {
        $customerModel->data['customer_id'] = $_POST['customer_id'];
    }

    if ($customerModel->save()) {
        header("Location: list.php?message=Updated successfully");
        exit;
    } else {
        header("Location: form.php?id=" . ($_POST['customer_id'] ?? '') . "&error=Failed to save customer.");
        exit;
    }
}

$id = $_GET['id'] ?? '';
header("Location: form.php?id=$id");
exit;
?>
