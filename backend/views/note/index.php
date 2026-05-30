<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var common\models\search\NoteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заметки';
$this->params['breadcrumbs'][] = $this->title;

$style = <<<CSS
.btnPin {
    margin-left: auto;
    display: inline-flex;
    align-items: center;
}
.blockPin {
    display: flex;
    align-items: center;
    width: 100%;
    border-radius: 5px;
}
.pagination {
	display: flex;
	gap: 5px;
}
CSS;
$this->registerCss($style);
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<p><?= Html::a('Создать заметку', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

	<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:15px;">

        <?php foreach ($dataProvider->models as $note): ?>
		<a href="<?= Url::to(['note/edit', 'id' => $note->id]) ?>"
		   style="text-decoration:none;color:inherit;">
	        <div
		        x-data="{ pinned: <?= $note->is_pinned ? 'true' : 'false' ?> }"
		        style="
			        border:1px solid #ddd;
			        padding:12px;
			        border-top:4px solid <?= htmlspecialchars($note->color) ?>;
			        border-radius:8px;
			        position:relative;
		        "
	        >

		        <div class="blockPin">
			        <div x-show="pinned">📌</div>
			        <button
					        @click.prevent="
					            fetch('<?= Url::to(['note/toggle-pin', 'id' => $note->id]) ?>', {
					                method: 'POST',
					                headers: {
					                    'X-CSRF-Token': yii.getCsrfToken()
					                }
					            })
					            .then(r => r.json())
					            .then(res => {
					                if (res.success) pinned = res.pinned
					            })
					        "
					        class="btnPin"
			        >
				        <span x-text="pinned ? 'Открепить' : 'Закрепить'"></span>
			        </button>
		        </div>

		        <h3><?= htmlspecialchars($note->title) ?></h3>
		        <p><?= htmlspecialchars($note->content) ?></p>

	        </div>
		</a>
        <?php endforeach; ?>

	</div>
	<div style="margin-top:20px;">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
        ]) ?>
	</div>

</div>
