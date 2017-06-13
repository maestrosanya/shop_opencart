<?php
class ControllerCommonSearch extends Controller {
	public function index() {
		$this->load->language('common/search');

			$this->load->model('catalog/product');
			$data['categories'] = array();
			$categories = $this->model_catalog_category->getCategories(0);
			foreach ($categories as $category) {
				$data['categories'][] = array(
					'category_id' => $category['category_id'],
					'name'        => $category['name'],
					'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
			

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		return $this->load->view('common/search', $data);
	}
}