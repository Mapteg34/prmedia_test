<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Fragment */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Add fragment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to add a code:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'add-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'type')->dropDownList($model->types) ?>

        <?= $form->field($model, 'code')->textarea() ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
