<?php

class EpisodeController extends Controller {
  public function index() {
    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    
    $episodes_model = new Episode();

    if ($isAjax) {

      $q = isset($_GET['episode_id']) ? filter_var($_GET['episode_id'], FILTER_SANITIZE_URL) : '';

      $episodes = array();

      if($q == ''){
        $episode_data = $episodes_model->findAll();
      } else {
        $episode_data = $episodes_model->findById($q);
      }

      if(is_array($episode_data)) {
        foreach($episode_data as $data) {
          array_push($episodes, $data);
        }
      } else {
        $episodes = [];
      }

      include VIEW_DIR . "components/episode/episode.php";
    } else {

      $q = isset($_GET['episode_id']) ? filter_var($_GET['episode_id'], FILTER_SANITIZE_URL) : '';
      
      $all_episode_data = $episodes_model->findAllEpisodeCard();     
      $episode_data = $episodes_model->findByIdEpisodeDetail($q);

      $data['episodes'] = $all_episode_data;
      $data['episode'] = $episode_data;

      $this->view('layouts/default', $data);

    }
  }
}