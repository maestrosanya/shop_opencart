<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

			$settings = $this->config->get('fastfood_settings');
			$settings = $settings[$this->config->get('config_store_id')][$this->config->get('config_language_id')];
			
			if (isset($settings['home_banner1'])) {$data['home_banner1'] = html_entity_decode($settings['home_banner1']);}
			if (isset($settings['home_banner2'])) {$data['home_banner2'] = html_entity_decode($settings['home_banner2']);}
			if (isset($settings['home_banner3'])) {$data['home_banner3'] = html_entity_decode($settings['home_banner3']);}
			

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}
