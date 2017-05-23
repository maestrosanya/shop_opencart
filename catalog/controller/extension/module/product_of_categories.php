<?php

class ControllerExtensionModuleProductOfCategories extends Controller
{
    public function index()
    {
        $this->load->language('extension/module/product_of_categories');
        
        $data['heading_title'] = $this->language->get('heading_title');

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $param_sort = [
            'filter_category_id' => 64
        ];

        $categories = $this->model_catalog_category->getCategories(0);

        $products = $this->model_catalog_product->getProducts($param_sort);

        var_dump($products);
    }
}