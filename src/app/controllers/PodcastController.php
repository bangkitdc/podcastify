<?php
require_once SERVICES_DIR . "/podcast/PodcastService.php";
require_once SERVICES_DIR . "/upload/UploadService.php";
require_once BASE_URL . "/src/app/views/components/podcast/episodesList.php";

class PodcastController extends BaseController
{
    private $podcast_service;

    public function __construct() {
        $this->podcast_service = new PodcastService();
    }

    public function index()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $isAjax = isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest";

                $podcasts = $this->podcast_service->getAllPodcast();

                $data["podcasts"] = $podcasts;

                if ($isAjax) {
                    $this->view("pages/podcast/index", $data);
                } else {
                    // If it"s not an AJAX request, include the full HTML structure
                    $this->view("layouts/default", $data);
                }
                break;

            case "POST":
                return;

            default:
                ResponseHelper::responseNotAllowedMethod();
                return;
        }
    }

    // /podcast/{id}
    public function podcast($id) {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $data["podcast"] = $this->podcast_service->getPodcastById($id);
        $data["episodes"] = $this->podcast_service->getEpisodesByPodcastId($id, 2, 1);

        $this->view("pages/podcast/podcast_detail", $data);
    }

    // /episodes?page=
    public function episodes($id) {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $page = isset($_GET["page"]) ? filter_var($_GET["page"], FILTER_SANITIZE_STRING) : 1;

        $data["episodes"] = $this->podcast_service->getEpisodesByPodcastId($id, 2, $page);

        return episodeList($data["episodes"]);
    }

    // /search?key=
    public function search() {
        $search_key = isset($_GET["key"]) ? filter_var($_GET["key"], FILTER_SANITIZE_STRING) : "";

        $podcasts = $this->podcast_service->getPodcastBySearch($search_key);

        include VIEWS_DIR . "pages/podcast/index.php";
    }

    public function edit($id) {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

                $data["podcast"] = $this->podcast_service->getPodcastById($id);
                $data["type"] = "edit";

                $this->view("pages/podcast/podcast_management", $data);
                break;
            case "PATCH":


                break;
        }
    }

    public function create($id) {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

                $data["type"] = "create";

                $this->view("pages/podcast/podcast_management", $data);
                break;
            case "POST":
                break;
        }
    }

    public function upload() {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "POST":
                UploadService::upload();
                break;
            default:
                ResponseHelper::responseNotAllowedMethod();
                break;
        }
    }
}
