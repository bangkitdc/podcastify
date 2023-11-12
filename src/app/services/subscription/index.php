<?php

require_once MODELS_DIR . 'Subscription.php';

class SubscriptionService {
    private $subscription_model;

    public function __construct(){
        $this->subscription_model = new Subscription();
    }

    public function getAllNewNotification($userID) {
        $notifications_data = $this->subscription_model->findAllNewNotifications($userID);
        $notifications = array();
        foreach ($notifications_data as $data) {
          array_push($notifications, $data);
        }

        $this->subscription_model->setAllToSeen($userID);
        $this->subscription_model->deleteAllRejectedNotification($userID);
        return $notifications;
    }

    public function addNewNotification($userID, $creatorID, $creatorName, $status) {
        $this->subscription_model->addNewNotification($userID, $creatorID, $creatorName, $status);
    }
}
