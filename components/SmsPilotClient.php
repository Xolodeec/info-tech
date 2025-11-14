<?php

namespace app\components;

use yii\base\Component;

/**
 * Класс-клиент для отправки SMS через Smspilot API-2 (JSON)
 */
class SmsPilotClient extends Component
{
    public $apiKey;

    private $apiUrl = 'https://smspilot.ru/api2.php';

    public function init()
    {
        if (empty($this->apiKey)) {
            throw new \InvalidArgumentException('API Key не может быть пустым');
        }
    }

    /**
     * Отправляет одно или несколько SMS-сообщений.
     * Формат элемента массива:
     *  [
     *  "to" => "79087964781", // Номер телефона в международном формате
     *  "text" => "Текст сообщения"
     *  // Можно добавить другие поля, например, "sender" для имени отправителя
     *  ]
     * @param array $messages Массив сообщений.
     * @return array|bool Результат ответа от API в виде массива PHP или false в случае ошибки.
     */
    public function sendSms(array $messages)
    {
        if (empty($messages)) {
            return false;
        }

        $requestData = [
            "apikey" => $this->apiKey,
            "send" => $messages
        ];

        $jsonRequest = json_encode($requestData);

        $ch = curl_init($this->apiUrl);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonRequest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($jsonRequest)
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            \Yii::error("SmsPilot cURL Error: " . curl_error($ch), __METHOD__);
            curl_close($ch);
            return false;
        }

        curl_close($ch);

        if ($httpCode !== 200) {
            // Ошибка HTTP
            \Yii::error("SmsPilot HTTP Error: " . $httpCode . " Response: " . $response, __METHOD__);
            return false;
        }

        return json_decode($response, true);
    }
}