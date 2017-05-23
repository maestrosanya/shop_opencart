<?php

/**
 * Created by PhpStorm.
 * User: Хоргдраммер
 * Date: 13.04.2017
 * Time: 20:10
 */
class ControllerExtensionModuleMaestro extends Controller
{
    private $error = array();

    public function index() {
        $this->load->language('extension/module/maestro');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('maestro', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
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
            'href' => $this->url->link('extension/module/maestro', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/module/maestro', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

        if (isset($this->request->post['maestro_status'])) {
            $data['maestro_status'] = $this->request->post['maestro_status'];
        } else {
            $data['maestro_status'] = $this->config->get('maestro_status');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/maestro/maestro', $data));

        // var_dump($this->registry);

    }

    public function add()
    {
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/maestro/maestro_add', $data));
    }

    public function edit() {
        $this->load->language('extension/module/maestro_edit');

       // $this->document->setTitle($this->language->get('heading_title'));

        //$this->load->model('catalog/category');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_add'] = $this->language->get('button_add');


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
            'href' => $this->url->link('extension/module/maestro', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/module/maestro/delete', 'token=' . $this->session->data['token'], true);

        $data['add'] = $this->url->link('extension/module/maestro/add', 'token=' . $this->session->data['token'], true);


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $custom_field = $this->db->query('SELECT * FROM oc_mstr_maestro');

        $ar_tmp = json_decode(json_encode($custom_field), true);

        foreach ($ar_tmp as $item){
            $data['custom_field'] = $item;
        }

        $this->response->setOutput($this->load->view('extension/module/maestro/maestro_fields', $data));

    }

    public function delete()
    {
        if ($this->request->server['REQUEST_METHOD'] == 'POST'){

            $str_id = '';

            if (isset($this->request->post['selected'])) {
                $str_id = implode(" ,", $this->request->post['selected']);

            }

            if ( $this->db->query("DELETE FROM " . DB_PREFIX . "mstr_maestro WHERE id IN ('$str_id')") ) {

                $this->response->redirect($this->url->link('extension/module/maestro/edit', 'token=' . $this->session->data['token'] , true));

            }

            //var_dump($str_id);



        }


        

    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/maestro')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    /**
     *  Установка модуля
     */
    public function install() {
        $this->load->model('extension/extension');
        $this->model_extension_extension->install('total', $this->request->get['extension']);
        /*
         * Создаём таблицу для модуля
         */
        $sql_create = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "mstr_maestro
                          (
                              `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                              `title` VARCHAR(255) NOT NULL,
                              `text` TEXT NULL,
                              `icon` VARCHAR(255) NULL,
                              `position` TINYINT(3) UNSIGNED 
                          )";

        $this->db->query($sql_create);
    }

    /**
     * Удаление модуля
     */
    public function uninstall() {
        $this->load->model('extension/extension');
        $this->model_extension_extension->uninstall('total', $this->request->get['extension']);
        $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting($this->request->get['extension']);
        /*
         * Удаляем таблицу модуля
         */
        $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "mstr_maestro");
    }


}