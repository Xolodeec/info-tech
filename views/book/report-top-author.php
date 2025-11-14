<?php

use app\models\entity\Book;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var array $data */

$this->title = 'Топ 10 авторов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table">
        <thead>
            <tr>
                <th>Фамилия авторов</th>
                <th>Кол-во книг</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= $row['author_name'] ?></td>
                    <td><?= $row['book_count'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
