<?php
include("Product.php");
class Add
{
    public function add()
    {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->saveProduct($_POST['product'] ?? [])) {
                header("Location: index.php?msg=inserted");
                exit;
            }
            $error = "Failed to save product.";
        }

        $this->render($error);
    }

    private function saveProduct($data)
    {
        $db = new Database();
        $db->connect();

        $data['created_date'] = date('Y-m-d H:i:s');
        $columns = implode(", ", array_keys($data));
        $values = array_map(function ($val) use ($db) {
            return "'" . addslashes((string)$val) . "'";
        }, array_values($data));
        $valuesStr = implode(", ", $values);

        $query = "INSERT INTO product ($columns) VALUES ($valuesStr)";
        return $db->insert($query);
    }

    private function render($error)
    {
        $product = new Product();
        $isEdit = false;
        include "form.html";
    }
}
if (basename($_SERVER['PHP_SELF']) == 'add.php') {
    $add = new Add();
    $add->add();
    }
?>