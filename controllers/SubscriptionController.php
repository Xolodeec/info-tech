<?php

namespace app\controllers;

use app\models\Subscription;
use app\models\SubscriptionRepository;
use app\models\SubscriptionService;
use yii\web\Controller;

class SubscriptionController extends Controller
{
    public function actionToggle(int $authorId)
    {
        try {
            $subscriptionRepository = new SubscriptionRepository();

            $service = new SubscriptionService($subscriptionRepository);
            $service->toggleSubscription(\Yii::$app->user->identity->id, $authorId);

            \Yii::$app->session->setFlash('success', 'Успешно выполнено');
        } catch (\Throwable $exception) {
            \Yii::$app->session->setFlash('error', $exception->getMessage());

        }

        return $this->redirect(\Yii::$app->request->referrer);
    }
}