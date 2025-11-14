<?php

namespace app\models;

class SubscriptionService
{
    private $repository;

    public function __construct(SubscriptionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function subscribe($userId, $authorId)
    {
        if ($this->repository->isSubscribed($userId, $authorId)) {
            throw new \Exception('Уже подписан на автора');
        }

        return $this->repository->createSubscription($userId, $authorId);
    }

    public function unsubscribe($userId, $authorId)
    {
        $subscription = $this->repository->findSubscription($userId, $authorId);

        if (!$subscription) {
            throw new \Exception('Подписка не найдена');
        }

        $this->repository->deleteSubscription($subscription);
    }

    public function toggleSubscription($userId, $authorId)
    {
        try {
            if ($this->repository->isSubscribed($userId, $authorId)) {
                $this->unsubscribe($userId, $authorId);
                return 'Отписан';
            } else {
                $this->subscribe($userId, $authorId);
                return 'Подписан';
            }
        } catch (\Exception $e) {
            throw new \Exception('Ошибка переключения подписки: ' . $e->getMessage());
        }
    }
}