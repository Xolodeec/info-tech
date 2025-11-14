<?php

namespace app\models\repository;

use app\models\entity\Subscription;

class SubscriptionRepository
{
    public function findSubscription($userId, $authorId)
    {
        return Subscription::findOne([
            'user_id' => $userId,
            'author_id' => $authorId
        ]);
    }

    public function createSubscription($userId, $authorId)
    {
        $subscription = new Subscription();
        $subscription->user_id = $userId;
        $subscription->author_id = $authorId;
        $subscription->created_at = time();

        if (!$subscription->save()) {
            throw new \Exception('Ошибка создания подписки');
        }

        return $subscription;
    }

    public function deleteSubscription(Subscription $subscription)
    {
        if (!$subscription->delete()) {
            throw new \Exception('Ошибка удаления подписки');
        }
    }

    public function isSubscribed($userId, $authorId)
    {
        return Subscription::find()
            ->where(['user_id' => $userId, 'author_id' => $authorId])
            ->exists();
    }
}
