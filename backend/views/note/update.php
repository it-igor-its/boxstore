<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Note $model */

$this->title = 'Редактирование заметки: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Заметки', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="note-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
