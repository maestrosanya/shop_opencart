<?php


class ModelExtensionModuleProductOfCategories extends Model
{
    public function getCategoryProductsId($category_id, $filter_name = '')
    {
        if ($filter_name) {
            $model = $filter_name;
        } else {
            $model = '';
        }

        $product =  DB_PREFIX . "product";
        $product_to_category = DB_PREFIX . "product_to_category";

        $query = $this->db->query("SELECT ".$product.".model, ".$product.".product_id FROM ".$product.",".$product_to_category." WHERE LOWER(`model`) LIKE '" . $model . "%' AND category_id IN(" . (string)$category_id . ") AND status='1' AND oc_product_to_category.product_id = oc_product.product_id LIMIT 5" );

        foreach ( $query as $item) {
            $products = $item;
        }
        return $products;
    }
    public function getCategories($category_name = '')
    {
        $category_description = DB_PREFIX . "category_description";

        $query = $this->db->query("SELECT `category_id` , `name` FROM " . $category_description . " WHERE LOWER(`name`) LIKE '" .$category_name. "%' LIMIT 5");

        foreach ( $query as $item) {
            $category = $item;
        }
        return $category;
    }

    /*public function getModuleSetting($name, $code) {
        $query = $this->db->query("SELECT setting FROM `" . DB_PREFIX . "module` WHERE name='".$name."' AND code='product_of_categories'");

        return $query->rows;
    }*/
}
