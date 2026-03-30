<?php

require_once '../Database.php';
require_once '../Row.php';

class ProductMedia extends Row {
    public $tableName = "product_media";
    public $primaryKey = "product_media_id";

    public function insert() : Row|false {
        $this->data['created_date'] = date('Y-m-d H:i:s');
        return parent::insert();
    }

    public function update() : Row|false {
        $this->data['updated_date'] = date('Y-m-d H:i:s');
        return parent::update();
    }
}
