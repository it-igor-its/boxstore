<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Dashboard';
$username = Yii::$app->user->identity?->username;
?>
<div class="site-index">
    <div class="dashboard-banner text-white rounded-4 p-4 p-lg-5 mb-4">
        <div class="row align-items-center">
	        <?= Html::a('Перейти в заметки', ['note/index'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
