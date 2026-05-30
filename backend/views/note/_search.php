<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\NoteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="note-search" style="margin-bottom: 20px;">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
	<div style="display: flex; align-items: flex-end; gap: 5px;">
	    <?= $form->field($model, 'q')->label('Поиск') ?>
	</div>
    <?php ActiveForm::end(); ?>
</div>