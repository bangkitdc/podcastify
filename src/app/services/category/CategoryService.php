<?php

require_once BASE_URL . '/src/app/models/Category.php';

class CategoryService {
  private $category_model;

  public function __construct() {
    $this->category_model = new Category();
  }

  public function getAllCategories() {
    $category_data = $this->category_model->findAll();

    $categories = array();

    foreach($category_data as $categorie) {
      array_push($categories, $categorie);
    }

    return $categories;
  }

  public function getCategoryById($id) {
    $category_data = $this->category_model->findById($id);

    $categories = array();

    if(is_object($category_data)){
      array_push($categories, $category_data);
    } else if (is_array($category_data)) {
      foreach($category_data as $category) {
        array_push($categories, $category);
      }
    } else {
      $categories = [];
    };

    return $categories;
  }

  public function getCategoryOfEpisode($episodeId){
    return $this->category_model->getCategoryOfEpisode($episodeId);
  }
}