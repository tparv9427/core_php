<?php
require_once '../Database.php';

$db = (new Database())->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    if (isset($_POST['selected_ids']) && !empty($_POST['selected_ids'])) {
        $ids = implode(',', array_map('intval', $_POST['selected_ids']));
        $sql = "DELETE FROM product_media WHERE product_media_id IN ($ids)";
        $db->delete($sql);
        header("Location: list.php?message=Selected media deleted successfully");
        exit;
    } else {
        header("Location: list.php?error=Please select at least one media item.");
        exit;
    }
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "DELETE FROM product_media WHERE product_media_id = $id";
    $db->delete($sql);
    header("Location: list.php?message=Media deleted successfully");
    exit;
}

header("Location: list.php");
exit;
?>
