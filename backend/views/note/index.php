<?php

use common\models\Note;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\NoteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заметки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a('Создать заметку', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


	<!-- SEARCH -->
	<form method="get" style="margin-bottom:15px;">
		<input
				type="text"
				name="q"
				placeholder="Search notes..."
				value="<?= Yii::$app->request->get('q') ?>"
				style="padding:6px;width:250px;"
				aria-label="Поиск"
		>
		<button type="submit">Search</button>
	</form>

	<!-- GRID -->
	<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:15px;">

        <?php foreach ($dataProvider->models as $note): ?>
			<div style="
					border:1px solid #ddd;
					padding:12px;
					border-top:4px solid <?= htmlspecialchars($note->color) ?>;
					border-radius:8px;
					background:#fff;
					">

				<h3><?= htmlspecialchars($note->title) ?></h3>

				<p><?= htmlspecialchars($note->content) ?></p>

				<small>
                    <?= $note->is_pinned ? 'Да' : 'Нет' ?>
				</small>

			</div>
        <?php endforeach; ?>

	</div>

</div>
