<?php

/**
 * Created by PhpStorm.
 * User: Хоргдраммер
 * Date: 13.04.2017
 * Time: 22:29
 */
class ControllerExtensionModuleMaestro extends Controller
{
    public function index()
    {
        $this->load->language('extension/module/maestro');

        //$this->load->model('extension/module/maestro');
        

        $text_strings = [
            'heading_title'
        ];

        foreach ($text_strings as $text){
            $data[$text] = $this->language->get($text);
        }
        $data['heading_title'] = $this->language->get('heading_title');

        //$data['posts'] = $this->model_extension_module_maestro->getPosts();

        
        return $this->load->view('extension/module/maestro', $data);

    }
}