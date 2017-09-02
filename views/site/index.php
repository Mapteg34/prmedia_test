<?php

/* @var $this \yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'PR Media test';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Добро пожаловать на сайт-пример для PR Медиа!</h1>
        <p><?=Html::a("Разместить отрывок кода", array("/site/add"), array(
            "class"=>"btn btn-lg btn-success"
        ))?></p>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'type',
            'username',
            "created_at:datetime",
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ]
        ],
    ]); ?>
</div>
