<?php

class ControllerExtensionModuleProductOfCategories extends Controller
{
    public $category_id = array();

    public $string_category_id = '';

    public $module_id = array();

    private $error = array();

    public function index() {
        $this->load->language('extension/module/product_of_categories');

        $this->load->model('extension/module');

        $this->document->setTitle($this->language->get('heading_title'));


        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_extension_module->addModule('product_of_categories', $this->request->post);
            } else {
                $this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
        }


        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_width'] = $this->language->get('entry_width');
        $data['entry_height'] = $this->language->get('entry_height');
        $data['entry_limit'] = $this->language->get('entry_limit');
        $data['entry_product'] = $this->language->get('entry_product');
        $data['entry_category'] = $this->language->get('entry_category');
        $data['entry_search_products'] = $this->language->get('entry_search_products');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/product_of_categories', 'token=' . $this->session->data['token'], true)
        );


        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/product_of_categories', 'token=' . $this->session->data['token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/product_of_categories', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

        $data['token'] = $this->session->data['token'];


        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
           
            $data['product_of_categories_id'] = $this->request->get['module_id'];
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }


        if (isset($this->request->post['product_of_categories_categories'])) {
            $data['product_of_categories_categories'] = $this->request->post['product_of_categories_categories'];
        } elseif (!empty($module_info)) {
            $data['product_of_categories_categories'] = $module_info['product_of_categories_categories'];
        } else {
            $data['product_of_categories_categories'] = '';
        }

        if (isset($this->request->post['product_of_categories_products'])) {
            $data['product_of_categories_products'] = $this->request->post['product_of_categories_products'];
        } elseif (!empty($module_info)) {
            $data['product_of_categories_products'] = $module_info['product_of_categories_products'];
        } else {
            $data['product_of_categories_products'] = '';
        }


        if (isset($this->request->post['width'])) {
            $data['width'] = $this->request->post['width'];
        } elseif (!empty($module_info)) {
            $data['width'] = $module_info['width'];
        } else {
            $data['width'] = '';
        }

        if (isset($this->request->post['height'])) {
            $data['height'] = $this->request->post['height'];
        } elseif (!empty($module_info)) {
            $data['height'] = $module_info['height'];
        } else {
            $data['height'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }

        $this->load->model('extension/module/product_of_categories');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/product_of_categories', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/product_of_categories')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }
        
        return !$this->error;
    }

    public function autocomplete()
    {
        $this->load->model('extension/module/product_of_categories');
        $this->load->model('extension/module');

        $json = array();

        if (isset($this->request->post['product_of_categories_categories'])) {

            $product_of_categories_product = $this->request->post['product_of_categories_categories'];

            if (isset($this->request->post['filter_name'])) {

                $filter_name = $this->request->post['filter_name'];

                $json = $this->model_extension_module_product_of_categories->getCategoryProductsId( $product_of_categories_product, $filter_name );

            }

        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));

    }

    public function getCategory()
    {

        $this->load->model('catalog/category');

        $json = array();

        if (isset($this->request->post['category_name'])) {
            
            if (isset($this->request->post['category_name'])) {
                $data['category_name'] = $this->request->post['category_name'];
            } elseif (!empty($module_info)) {
                $data['category_name_one'] = $module_info['category_name'];
            } else {
                $data['category_name'] = '';
            }

            $filter_Category = array(
                'filter_name' => $data['category_name']
            );

            $json = $this->model_catalog_category->getCategories($filter_Category);

        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}