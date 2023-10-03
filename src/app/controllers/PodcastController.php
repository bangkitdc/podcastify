<?php

require_once BASE_URL . "/src/app/helpers/ResponseHelper.php";
require_once BASE_URL . "/src/app/helpers/SanitizeHelper.php";
require_once SERVICES_DIR . "/podcast/index.php";
require_once SERVICES_DIR . "/upload/index.php";
require_once SERVICES_DIR . "/category/index.php";
require_once BASE_URL . "/src/app/views/components/privates/podcast/episodesList.php";

class PodcastController extends BaseController
{
    private $podcast_service;
    private $upload_service;
    private $category_service;

    public function __construct() {
        $this->podcast_service = new PodcastService();
        $this->upload_service = new UploadService();
        $this->category_service = new CategoryService();
    }

    public function index()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $isAjax = isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest";

                $data["podcasts"] = $this->podcast_service->getPodcast(4, 1);
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
                    $data["category"] = $this->category_service->getCategoryNameById($data["podcast"]->category_id);

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
                    $page = Sanitizer::sanitizeIntParam("page");

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
                    $page = Sanitizer::sanitizeIntParam("page");

                    $data["podcasts"] = $this->podcast_service->getPodcast(4, $page);
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

    // TODO: check
    public function search() {
        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $q = Sanitizer::sanitizeStringParam("q");

                    if ($q == "") {
                        $this->index();
                        return ResponseHelper::HTTP_STATUS_OK;
                    }

                    $sort_method = Sanitizer::sanitizeStringParam("sort");
                    $sort_key = Sanitizer::sanitizeStringParam("key");
                    $filter_names = Sanitizer::sanitizeStringArrayParam("filter_name");
                    $filter_categories_name = Sanitizer::sanitizeStringArrayParam("filter_category");
                    $page_requested = Sanitizer::sanitizeIntParam("page");
                    $page = $page_requested == "" ? 1 : $page_requested;

                    if (!empty($filter_categories_name)) {
                        $filter_categories = array();
                        foreach ($filter_categories_name as $name) {
                            $cat_id = $this->category_service->getCategoryIdByName($name);
                            array_push($filter_categories, $cat_id);
                        }
                    }

                    $data['podcasts'] = $this->podcast_service->getPodcastBySearch($q, $sort_method, $sort_key, $filter_names, $filter_categories, $page, 4);

                    $this->view('pages/podcast/index', $data);
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
                    $data["categories"] = $this->category_service->getAllCategoryNames();
                    $data["podcast_category"] = $this->category_service->getCategoryNameById($data["podcast"]->category_id);

                    $this->view("layouts/default", $data);
                    return ResponseHelper::HTTP_STATUS_OK;

                case "PATCH":
                    $data = json_decode(file_get_contents('php://input'), true);

                    $title = filter_var($data['podcast-name-input'], FILTER_SANITIZE_STRING);
                    $creator_name = filter_var($data['podcast-creator-input'], FILTER_SANITIZE_STRING);
                    $description = filter_var($data['podcast-desc-input'], FILTER_SANITIZE_STRING);
                    $category_name = filter_var($data['podcast-category-selection'], FILTER_SANITIZE_STRING);

                    $category_id = $this->category_service->getCategoryIdByName($category_name);

                    if (isset($data['preview-image-filename'])) {
                        $image_url = filter_var($data['preview-image-filename'], FILTER_SANITIZE_STRING);
                    } else {
                        $image_url = "";
                    }

                    $this->podcast_service->updatePodcast($id, $title, $description, $creator_name, $image_url, $category_id);
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

    // /add
    public function add() {
        try {
            if (!Middleware::isAdmin()) throw new Exception("Unauthorized");
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $data["type"] = "create";
                    $data["categories"] = $this->category_service->getAllCategoryNames();
                    $this->view("layouts/default", $data);
                    break;

                case "POST":
                    $title = filter_var($_POST['podcast-name-input'], FILTER_SANITIZE_STRING);
                    $creator_name = filter_var($_POST['podcast-creator-input'], FILTER_SANITIZE_STRING);
                    $description = filter_var($_POST['podcast-desc-input'], FILTER_SANITIZE_STRING);
                    $image_url = filter_var($_POST['preview-image-filename'], FILTER_SANITIZE_STRING);
                    $category_name = filter_var($_POST['podcast-category-selection'], FILTER_SANITIZE_STRING);

                    $category_id = $this->category_service->getCategoryIdByName($category_name);

                    $this->podcast_service->createPodcast($title, $description, $creator_name, $image_url, $category_id);
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
