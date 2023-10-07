<?php

class HomeController extends BaseController
{
    public function index($params=null)
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case "GET":
                    if ($params !== null) {
                        $this->view('layouts/error');
                        return;
                    }

                    $this->view('layouts/default');
                    return;
                case "POST":
                    return;
                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            $this->view('layouts/error');
            exit;
        }
    }
}
