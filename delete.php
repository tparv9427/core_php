<?php
require_once "Product.php";

class Delete
{
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
            $this->performDelete($_POST['selected_ids'] ?? []);
        }
        header("Location: index.php");
        exit;
    }

    private function performDelete($ids)
    {
        if (!empty($ids) && is_array($ids)) {
            $db = new Database();
            $db->connect();
            
            $idList = implode(',', array_map('intval', $ids));
            $db->delete("DELETE FROM product WHERE product_id IN ($idList)");
            header("Location: index.php?msg=deleted");
            exit;
        }
    }
}

$delete = new Delete();
$delete->delete();
?>
