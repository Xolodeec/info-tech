<?php

namespace app\components;

use Yii;
use app\models\entity\Book;
use app\models\entity\Subscription;
use yii\base\Event;

/**
 * Обработчик, который реагирует на событие сохранения новой книги
 * и отправляет SMS подписчикам.
 */
class SmsNotificationHandler
{
    /**
     * Метод-обработчик события.
     * @param Event $event Событие, в котором $event->sender - это модель Book.
     */
    public static function handleNewBook(Event $event)
    {
        /** @var Book $book */
        $bookAuthor = $event->sender;
        $book = $bookAuthor->book;
        $author = $bookAuthor->author;
        $user = $book->createdBy;

        $message = 'Добавлена новая книга - ' . $book->title . ' от ' . $author->last_name . ' ' . $author->first_name . '!';

        $result = Yii::$app->smsPilot->sendSms([
            [
                'to' => $user->phone,
                'text' => $message,
            ]
        ]);


        if ($result !== false) {
            Yii::info("SMS успешно отправлены для книги ID: " . $book->id . ". Ответ: " . print_r($result, true), 'sms');
        } else {
            Yii::error("Ошибка отправки SMS для книги ID: " . $book->id, 'sms');
        }
    }
}