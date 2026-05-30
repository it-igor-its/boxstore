<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Note $model */
/** @var yii\widgets\ActiveForm $form */

$color = $model->color ?? '#6366f1';
?>

<div class="note-form">

    <?php $form = ActiveForm::begin([
        'action' => $model->isNewRecord ? ['store', 'id' => $model->id] : ['update', 'id' => $model->id],
        'id' => 'card-form',
        'options' => ['class' => 'form-horizontal col-sm-10', 'style' => 'margin-top: 20px;'],
        'fieldConfig' => [
            'template' => '{label}<div class="col-sm-6">{input}{error}</div>',
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
            'inputOptions' => ['class' => 'form-control input-sm'],
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

	<div x-data="colorPicker()" style="margin-bottom:15px;">

		<input type="hidden" name="Note[color]" :value="selected">

		<label>Цвет</label>

		<div style="display:flex;gap:10px;margin-top:8px;">

			<template x-for="color in colors" :key="color">
				<div
						@click="selected = color"
						:style="`
                        width:28px;
                        height:28px;
                        border-radius:50%;
                        cursor:pointer;
                        background:${color};
                        border:${selected === color ? '3px solid #000' : '2px solid #ddd'};
                        transition:0.2s;
                        transform:${selected === color ? 'scale(1.1)' : 'scale(1)'};
                    `"
				></div>
			</template>

		</div>

	</div>

    <div class="form-group" style="gap: 10px; display: flex;">
	    <?php
	    echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
		echo Html::a('Отменить', ['index'], ['class' => 'btn btn-info']);
	    if (!$model->isNewRecord) {
            echo Html::a('Удалить', ['destroy', 'id' => $model->id], ['class' => 'btn btn-danger']);
	    }
	    ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('colorPicker', () => ({
			colors: [
				'#6366f1',
				'#ef4444',
				'#10b981',
				'#f59e0b',
				'#3b82f6',
				'#a855f7'
			],
			selected: '<?= $color ?>'
		}))
	})
</script>