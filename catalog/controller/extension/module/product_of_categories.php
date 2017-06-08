<?php

class ControllerExtensionModuleProductOfCategories extends Controller
{
    public function index($setting)
    {
        $this->document->addStyle('catalog/view/css/product_of_categories.css');
        $this->document->addScript('catalog/view/javascript/product_of_categories.js');

        $this->load->language('extension/module/product_of_categories');
        
        $data['heading_title'] = $setting['name'];
        $data['button_cart'] = $this->language->get('button_cart');
        $data['button_wishlist'] = $this->language->get('button_wishlist');
        $data['button_compare'] = $this->language->get('button_compare');
        $data['text_tax'] = $this->language->get('text_tax');

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');


        $set['products'] = array();

        array_push($set['products'], $setting);

        foreach ($set['products'] as $item) {
            $set_products[] = $item;
        }


        if ( !empty($setting['product_of_categories_products']) ) {

            foreach ($setting['product_of_categories_products'] as $products) {
                $arr_products[] = explode("|", $products);

            }
            foreach ($arr_products as $item) {
                $arr_id[] =  $item[0];
                $str_id = implode(", ", $arr_id);
            }
        }
        
        $data['products'] = array();

        $products = explode(',', $str_id);


        foreach ($products as $product_id) {


            $product_info = $this->model_catalog_product->getProduct($product_id);

            if ($product_info['image']) {
                $image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
            }

            if ((float)$product_info['special']) {
                $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $special = false;
            }

            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $price = false;
            }

            if ($this->config->get('config_review_status')) {
                $rating = $product_info['rating'];
            } else {
                $rating = false;
            }

            $data['products'][] = array(
                'product_id'    => $product_info['product_id'],
                'name'          => $product_info['name'],
                'thumb'         => $image,
                'special'       => $special,
                'description'   => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                'price'         => $price,
                'rating'        => $rating,
                'href'          => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
            );

        }
        
        return $this->load->view('extension/module/product_of_categories', $data);
    }
}