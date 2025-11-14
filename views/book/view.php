<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \app\models\entity\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!\Yii::$app->user->isGuest): ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <?= $model->getAttributeLabel('title') ?>
            </div>
            <div class="col">
                <?= $model->title ?>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <?= $model->getAttributeLabel('year') ?>
            </div>
            <div class="col">
                <?= $model->year ?>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <?= $model->getAttributeLabel('description') ?>
            </div>
            <div class="col">
                <?= $model->description ?>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <?= $model->getAttributeLabel('isbn') ?>
            </div>
            <div class="col">
                <?= $model->isbn ?>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <?= $model->getAttributeLabel('authorIds') ?>
            </div>
            <div class="col">
                <ul>
                <?php foreach ($model->authors as $author): ?>
                    <li>
                        <?= $author->last_name . ' ' . $author->first_name ?>

                        <?php if (!\Yii::$app->user->isGuest): ?>
                        <?= \yii\bootstrap5\Html::a('[Подписаться на автора]', ['/subscription/toggle', 'authorId' => $author->id]) ?>
                        <?php endif; ?>

                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <?= $model->getAttributeLabel('photo') ?>
            </div>
            <div class="col">
                <img src="<?= $model->photo ?>" class="img-fluid">
            </div>
        </div>
    </div>

</div>
