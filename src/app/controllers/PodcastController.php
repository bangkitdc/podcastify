<?php

require_once BASE_URL . "/src/app/helpers/ResponseHelper.php";
require_once SERVICES_DIR . "/podcast/PodcastService.php";
require_once SERVICES_DIR . "/upload/UploadService.php";
require_once BASE_URL . "/src/app/views/components/podcast/episodesList.php";

class PodcastController extends BaseController
{
    private $podcast_service;
    private $upload_service;

    public function __construct() {
        $this->podcast_service = new PodcastService();
        $this->upload_service = new UploadService();
    }

    public function index()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $isAjax = isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest";

                $data["podcasts"] = $this->podcast_service->getPodcast(2, 1);
                $data["total_rows"] = $this->podcast_service->getTotalRows();

                if ($isAjax) {
                    $this->view("pages/podcast/index", $data);
                } else {
                    // If it"s not an AJAX request, include the full HTML structure
                    $this->view("layouts/default", $data);
                }
                return;

            default:
                ResponseHelper::responseNotAllowedMethod();
                return;
        }
    }

    // /show/{id}
    public function show($id) {
        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

                    $data["podcast"] = $this->podcast_service->getPodcastById($id);
                    $data["episodes"] = $this->podcast_service->getEpisodesByPodcastId($id, 2, 1);

                    $this->view("layouts/default", $data);
                    return ResponseHelper::HTTP_STATUS_OK;

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            $this->view('layouts/error');
            exit;
        }
    }

    // /episodes?page=
    public function episodes($id) {
        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
                    $page = isset($_GET["page"]) ? filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT) : 1;

                    $data["episodes"] = $this->podcast_service->getEpisodesByPodcastId($id, 2, $page);

                    return episodeList($data["episodes"]);

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            $this->view('layouts/error');
            exit;
        }
    }

    public function podcasts() {
        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $page = isset($_GET["page"]) ? filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT) : 1;

                    $data["podcasts"] = $this->podcast_service->getPodcast(2, $page);
                    $data["total_rows"] = $this->podcast_service->getTotalRows();

                    $this->view('pages/podcast/index', $data);
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

    // /search?key=
    public function search() {
        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $search_key = isset($_GET["key"]) ? filter_var($_GET["key"], FILTER_SANITIZE_STRING) : "";

                    $data['podcasts'] = $this->podcast_service->getPodcastBySearch($search_key);

                    $this->view("layouts/default", $data);
                    return ResponseHelper::HTTP_STATUS_OK;

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            $this->view('layouts/error');
            exit;
        }
    }

    // /edit/{id}
    public function edit($id) {
        try {
            if (!Middleware::isAdmin()) throw new Exception("Unauthorized");

            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $data["podcast"] = $this->podcast_service->getPodcastById($id);
                    $data["type"] = "edit";

                    $this->view("layouts/default", $data);
                    return ResponseHelper::HTTP_STATUS_OK;

                case "PATCH":
                    $data = json_decode(file_get_contents('php://input'), true);

                    $title = filter_var($data['podcast-name-input'], FILTER_SANITIZE_STRING);
                    $creator_name = filter_var($data['podcast-creator-input'], FILTER_SANITIZE_STRING);
                    $description = filter_var($data['podcast-desc-input'], FILTER_SANITIZE_STRING);
                    if (isset($data['preview-image-filename'])) {
                        $image_url = filter_var($data['preview-image-filename'], FILTER_SANITIZE_STRING);
                    } else {
                        $image_url = "";
                    }

                    $this->podcast_service->updatePodcast($id, $title, $description, $creator_name, $image_url);
                    return ResponseHelper::HTTP_STATUS_OK;

                case "DELETE":
                    $this->podcast_service->deletePodcast($id);
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

    // /create
    public function create() {
        try {
            if (!Middleware::isAdmin()) throw new Exception("Unauthorized");

            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $data["type"] = "create";

                    $this->view("layouts/default", $data);
                    break;

                case "POST":
                    $title = filter_var($_POST['podcast-name-input'], FILTER_SANITIZE_STRING);
                    $creator_name = filter_var($_POST['podcast-creator-input'], FILTER_SANITIZE_STRING);
                    $description = filter_var($_POST['podcast-desc-input'], FILTER_SANITIZE_STRING);
                    $image_url = filter_var($_POST['preview-image-filename'], FILTER_SANITIZE_STRING);

                    $this->podcast_service->createPodcast($title, $description, $creator_name, $image_url);
                    break;

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            $this->view('layouts/error');
            exit;
        }
    }

    // /upload
    public function upload() {
        if (!Middleware::isAdmin()) throw new Exception("Unauthorized");

        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "POST":
                    $this->upload_service->upload();
                    return;

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    break;
            }
        } catch (Exception $e) {
            $this->view('layouts/error');
            exit;
        }
    }
}
