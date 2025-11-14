<?php
namespace app\models\service;

use app\models\entity\Book;
use app\models\entity\Author;
use app\models\entity\BookAuthor;
use yii\db\Query;

class BookReportService
{
    /**
     * Возвращает ТОП-авторов по количеству выпущенных книг за указанный год.
     *
     * @param int $year Год для фильтрации.
     * @param int $limit Ограничение на количество авторов.
     * @return array Результаты запроса (автор и количество книг).
     */
    public function getTopAuthorsByYear(int $year, int $limit = 10): array
    {
        // Создаем сложный SQL-запрос с JOIN, GROUP BY и COUNT.
        $query = (new Query())
            ->select([
                'author_name' => 'a.last_name',
                'book_count' => 'COUNT(b.id)'
            ])
            ->from(['b' => Book::tableName()])
            // Соединяем с промежуточной таблицей book_author
            ->innerJoin(['ba' => BookAuthor::tableName()], 'ba.book_id = b.id')
            // Соединяем с таблицей авторов
            ->innerJoin(['a' => Author::tableName()], 'a.id = ba.author_id')
            // Фильтруем по выбранному году
            ->where(['b.year' => $year])
            // Группируем по автору (по ID и имени)
            ->groupBy(['a.id', 'a.last_name'])
            // Сортируем по убыванию количества книг
            ->orderBy(['book_count' => SORT_DESC])
            // Ограничиваем результат
            ->limit($limit);

        return $query->all();
    }
}