<?php

class HomeController extends BaseController
{
    public function index()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                // $search_service = new SearchService();
                // if (isset($_GET['page']) and $_GET['page'] > 0) {
                //     $page = $_GET['page'];
                // } else {
                //     $page = 1;
                // }

                // $data = $search_service->search_all_song($page);

                $this->view('layouts/default', $data=[]);
                return;
            case "POST":
                return;
            default:
                ResponseHelper::responseNotAllowedMethod();
                return;
        }
    }
}
