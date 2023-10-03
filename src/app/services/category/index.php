<?php

require_once MODELS_DIR . 'Category.php';

class CategoryService {
    private $category_model;

    public function __construct(){
        $this->category_model = new Category();
    }

    public function getAllCategories() {
        $categories_data =$this->category_model->findAll();
        $categories = array();
        foreach ($categories_data as $data) {
          array_push($categories, $data);
        }
        return $categories;
    }

    public function getAllCategoryNames() {
        $categories_data =$this->category_model->findAll();
        $category_names = array();
        foreach ($categories_data as $data) {
          array_push($category_names, $data->name);
        }
        return $category_names;
    }

    public function getCategoryNameById($id) {
        $category_data = $this->category_model->findById($id);
        return $category_data->name;
    }

    public function getCategoryIdByName($name) {
        $category_data = $this->category_model->findByName($name);
        return $category_data->category_id;
    }
}
