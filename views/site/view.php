<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->registerCssFile("//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css");
$this->registerJsFile("//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js");
$this->registerJs("hljs.initHighlightingOnLoad();");

$this->title = 'View fragment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add">
    <h1><?=Html::encode($this->title) ?></h1>
     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            '_id',
            'type',
            'username',
            'created_at:datetime'
        ],
    ]) ?>
    <pre><code><?=htmlspecialchars($model->code)?></code></pre>
</div>
