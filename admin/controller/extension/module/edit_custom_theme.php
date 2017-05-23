<?php

class ControllerExtensionModuleEditCustomTheme extends Controller
{
    private $error = array();

    public function index() {
        $this->load->language('extension/module/edit_custom_theme');

        $this->load->model('extension/module');

        $this->document->setTitle($this->language->get('heading_title'));


        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_extension_module->addModule('edit_custom_theme', $this->request->post);
            } else {
                $this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $text_string = array(
            'heading_title',
            'text_edit',
            'text_enabled',
            'text_disabled',
            'error_name',
            'entry_name',
            'entry_status',
            'button_save',
            'button_cancel',
        );

        /*$data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');*/

        foreach ($text_string as $text){
            $data[$text] = $this->language->get($text);
        }

        // Custom fields
        $data['custom_text'] = $this->language->get('custom_text');

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
            'href' => $this->url->link('extension/module/edit_custom_theme', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/module/edit_custom_theme', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

        if (isset($this->request->post['edit_custom_theme_status'])) {
            $data['edit_custom_theme_status'] = $this->request->post['edit_custom_theme_status'];
        } else {
            $data['edit_custom_theme_status'] = $this->config->get('edit_custom_theme_status');
        }

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        // Error Custom fields

        if (isset($this->error['text_warranty'])) {
            $data['error_text_warranty'] = $this->error['text_warranty'];
        } else {
            $data['error_text_warranty'] = '';
        }

        // Custom module fields

        if (isset($this->request->post['text_warranty'])) {
            $data['text_warranty'] = $this->request->post['text_warranty'];
        } elseif (!empty($module_info)) {
            $data['text_warranty'] = $module_info['text_warranty'];
        } else {
            $data['text_warranty'] = '';
        }


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/edit_custom_theme', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/edit_custom_theme')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }
}