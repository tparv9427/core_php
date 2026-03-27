<?php
require_once "Product.php";

class Update
{
    public function update()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header("Location: index.php");
            exit;
        }

        $id = $_GET['id'];
        $product = $this->getProduct($id);

        if (!$product) {
            header("Location: index.php?error=notfound");
            exit;
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->saveProduct($id, $_POST['product'] ?? [])) {
                header("Location: index.php?msg=updated");
                exit;
            }
            $error = "Failed to update product.";
        }

        $this->render($product, $error);
    }

    private function getProduct($id)
    {
        $db = new Database();
        $db->connect();
        $record = $db->fetchRow("SELECT * FROM product WHERE product_id = '{$id}' LIMIT 1");
        
        if ($record) {
            $product = new Product();
            $product->setData($record);
            return $product;
        }
        return null;
    }

    private function saveProduct($id, $data)
    {
        $db = new Database();
        $db->connect();

        $data['updated_date'] = date('Y-m-d H:i:s');
        $setParts = [];
        foreach ($data as $key => $val) {
            $setParts[] = "$key = '" . addslashes((string)$val) . "'";
        }
        $setStr = implode(", ", $setParts);

        $query = "UPDATE product SET {$setStr} WHERE product_id = '{$id}'";
        return $db->update($query);
    }

    private function render($product, $error)
    {
        $isEdit = true;
        include "form.html";
    }
}

$update = new Update();
$update->update();
?>
