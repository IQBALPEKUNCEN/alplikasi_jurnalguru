<?php

use app\modules\UserManagement\extensions\DateRangePicker\DateRangePicker;
use app\modules\UserManagement\extensions\GridPageSize\GridPageSize;
use app\modules\UserManagement\UserManagementModule;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\UserManagement\models\search\UserVisitLogSearch $searchModel
 */

$this->title = UserManagementModule::t('back', 'Visit log');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-visit-log-index">

	<?php // echo $this->render('_search', ['model' => $searchModel]); 
	?>

	<div class="panel panel-default">

		<div class="panel-body">

			<div class="row mb-2">
				<div class="col-sm-12 text-right">
					<?= GridPageSize::widget(['pjaxId' => 'user-visit-log-grid-pjax']) ?>
				</div>
			</div>

			<?php Pjax::begin([
				'id' => 'user-visit-log-grid-pjax',
			]) ?>

			<?= GridView::widget([
				'id' => 'user-visit-log-grid',
				'dataProvider' => $dataProvider,
				'pager' => [
					'options' => ['class' => 'pagination pagination-sm'],
					'hideOnSinglePage' => true,
					'lastPageLabel' => 'Last',
					'firstPageLabel' => 'First',
				],
				'layout' => '{items}<div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">{summary}</div></div>',
				'filterModel' => $searchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width:10px']],

					[
						'attribute' => 'user_id',
						'value' => function ($model) {
							return Html::a(@$model->user->username, ['view', 'id' => $model->id], ['data-pjax' => 0]);
						},
						'format' => 'raw',
					],
					'language',
					'os',
					'browser',
					array(
						'attribute' => 'ip',
						'value' => function ($model) {
							return Html::a($model->ip, "http://ipinfo.io/" . $model->ip, ["target" => "_blank"]);
						},
						'format' => 'raw',
					),
					[
						'attribute' => 'visit_time',
						'value' => function ($model) {
							return date('d-m-Y H:i:s', $model->visit_time);
						}
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'template' => '{view}',
						'contentOptions' => ['class' => 'nowrap text-center'],
					],
				],
			]); ?>

			<?php Pjax::end() ?>
		</div>
	</div>
</div>

<?php DateRangePicker::widget([
	'model'     => $searchModel,
	'attribute' => 'visit_time',
]) ?>