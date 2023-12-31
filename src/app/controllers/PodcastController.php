<?php

require_once SERVICES_DIR . "/podcast/index.php";
require_once SERVICES_DIR . "/upload/index.php";
require_once SERVICES_DIR . "/category/index.php";
require_once BASE_URL . "/src/app/views/components/privates/podcast/episodesList.php";
require_once BASE_URL . '/src/config/storage.php';

class PodcastController extends BaseController
{
    private $podcast_service;
    private $upload_service;
    private $category_service;
    private const MAX_PODCAST_PER_PAGE = 8;
    private const MAX_EPS_PER_PODCAST_DETAIL = 4;

    public function __construct() {
        $this->podcast_service = new PodcastService();
        $this->upload_service = new UploadService(Storage::PODCAST_IMAGE_PATH);
        $this->category_service = new CategoryService();
    }

    public function index()
    {
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $isAjax = isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest";

                $data["podcasts"] = $this->podcast_service->getPodcast(PodcastController::MAX_PODCAST_PER_PAGE, 1);
                $data["total_rows"] = $this->podcast_service->getTotalRows();
                $data['categories'] = $this->category_service->getAllCategoryNames();
                $data['creators'] = $this->podcast_service->getAllCreatorName();

                if ($isAjax) {
                    $this->view("pages/podcast/index", $data);
                } else {
                    // If it"s not an AJAX request, include the full HTML structure
                    $this->view("layouts/default", $data);
                }
                http_response_code(ResponseHelper::HTTP_STATUS_OK);
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
                    $data["episodes"] = $this->podcast_service->getEpisodesByPodcastId($id, PodcastController::MAX_EPS_PER_PODCAST_DETAIL, 1);
                    $data["category"] = $this->category_service->getCategoryNameById($data["podcast"]->category_id);

                    $this->view("layouts/default", $data);
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    return;

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            $response = array("success" => false, "error_message" => $e->getMessage());
            echo json_encode($response);
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

                    $data["episodes"] = $this->podcast_service->getEpisodesByPodcastId($id, PodcastController::MAX_EPS_PER_PODCAST_DETAIL, $page);

                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    return episodeList($data["episodes"]);

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            $response = array("success" => false, "error_message" => $e->getMessage());
            echo json_encode($response);
            exit;
        }
    }

    public function podcasts() {
        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $page = Sanitizer::sanitizeIntParam("page");

                    $data["podcasts"] = $this->podcast_service->getPodcast(PodcastController::MAX_PODCAST_PER_PAGE, $page);
                    $data["total_rows"] = $this->podcast_service->getTotalRows();
                    $data["is_ajax"] = true;

                    $this->view('pages/podcast/index', $data);
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    return;

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            $response = array("success" => false, "error_message" => $e->getMessage());
            echo json_encode($response);
            exit;
        }
    }

    // for search bar
    public function search() {
        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $q = Sanitizer::sanitizeStringParam("q");


                    $sort_method = Sanitizer::sanitizeStringParam("sort");
                    $sort_key = Sanitizer::sanitizeStringParam("key");
                    $filter_names = Sanitizer::sanitizeStringArrayParam("filter_name");
                    $filter_categories_name = Sanitizer::sanitizeStringArrayParam("filter_category");
                    $page_requested = Sanitizer::sanitizeIntParam("page");
                    $page = $page_requested == "" ? 1 : $page_requested;

                    $filter_categories = array();
                    if (!empty($filter_categories_name)) {
                        foreach ($filter_categories_name as $name) {
                            $cat_id = $this->category_service->getCategoryIdByName($name);
                            array_push($filter_categories, $cat_id);
                        }
                    } else {
                        $filter_categories = [];
                    }

                    list($data['total_rows'], $data['podcasts']) = $this->podcast_service->getPodcastBySearch($q, $sort_method, $sort_key, $filter_names, $filter_categories, $page, PodcastController::MAX_PODCAST_PER_PAGE);

                    $data['is_ajax'] = false;

                    $this->view('pages/podcast/index', $data);
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    return;

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            $response = array("success" => false, "error_message" => $e->getMessage());
            echo json_encode($response);
            exit;
        }
    }

    // /edit/{id}
    public function edit($id) {
        try {
            Middleware::checkIsAdmin();
            Middleware::checkIsLoggedIn();
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $data["podcast"] = $this->podcast_service->getPodcastById($id);
                    $data["type"] = "edit";
                    $data["categories"] = $this->category_service->getAllCategoryNames();
                    $data["podcast_category"] = $this->category_service->getCategoryNameById($data["podcast"]->category_id);

                    $this->view("layouts/default", $data);
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    return;

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
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    return;

                case "DELETE":
                    $this->podcast_service->deletePodcast($id);
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    return;

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            if ($e->getCode() == ResponseHelper::HTTP_STATUS_UNAUTHORIZED) {
                $this->view('layouts/error');
                return;
            }

            http_response_code($e->getCode());
            $response = array("success" => false, "error_message" => $e->getMessage());
            echo json_encode($response);
            exit;
        }
    }

    // /add
    public function add() {

        try {
            Middleware::checkIsAdmin();
            Middleware::checkIsLoggedIn();
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "GET":
                    $data["type"] = "create";
                    $data["categories"] = $this->category_service->getAllCategoryNames();
                    $this->view("layouts/default", $data);
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    break;

                case "POST":
                    $title = filter_var($_POST['podcast-name-input'], FILTER_SANITIZE_STRING);
                    $creator_name = filter_var($_POST['podcast-creator-input'], FILTER_SANITIZE_STRING);
                    $description = filter_var($_POST['podcast-desc-input'], FILTER_SANITIZE_STRING);
                    $image_url = filter_var($_POST['preview-image-filename'], FILTER_SANITIZE_STRING);
                    $category_name = filter_var($_POST['podcast-category-selection'], FILTER_SANITIZE_STRING);

                    $category_id = $this->category_service->getCategoryIdByName($category_name);

                    $this->podcast_service->createPodcast($title, $description, $creator_name, $image_url, $category_id);
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    break;

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    return;
            }
        } catch (Exception $e) {
            if ($e->getCode() == ResponseHelper::HTTP_STATUS_UNAUTHORIZED) {
                $this->view('layouts/error');
                return;
            }

            http_response_code($e->getCode());
            $response = array("success" => false, "error_message" => $e->getMessage());
            echo json_encode($response);
            exit;
        }
    }

    // /random
    public function random($limit) {
        try {
            $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);
            $data = $this->podcast_service->getRandomPodcasts($limit);
            $response = array("success" => true, "status_message" => "Fetched successfully", "data" => $data);
            http_response_code(ResponseHelper::HTTP_STATUS_OK);

            header('Content-Type: application/json');

            echo json_encode($response);
            return;
        } catch (Exception $e) {
            http_response_code($e->getCode());
            $response = array("success" => false, "error_message" => $e->getMessage());
            echo json_encode($response);
            exit;
        }
    }

    // /upload
    public function upload() {
        Middleware::checkIsAdmin();

        try {
            switch ($_SERVER["REQUEST_METHOD"]) {
                case "POST":
                    $this->upload_service->upload("image");
                    http_response_code(ResponseHelper::HTTP_STATUS_OK);
                    return;

                default:
                    ResponseHelper::responseNotAllowedMethod();
                    break;
            }
        } catch (Exception $e) {
            if ($e->getCode() == ResponseHelper::HTTP_STATUS_UNAUTHORIZED) {
                $this->view('layouts/error');
                return;
            }

            http_response_code($e->getCode());
            $response = array("success" => false, "error_message" => $e->getMessage());
            echo json_encode($response);
            return;
        }
    }
}
