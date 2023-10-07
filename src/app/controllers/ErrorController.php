<?php

class ErrorController extends BaseController
{
    public function index()
    {
        $this->view('layouts/error');
        return;
    }
}