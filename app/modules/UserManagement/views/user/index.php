<?php

use app\modules\UserManagement\components\basecomponents\StatusColumn;
use app\modules\UserManagement\components\GhostHtml;
use app\modules\UserManagement\extensions\GridBulkActions\GridBulkActions;
use app\modules\UserManagement\extensions\GridPageSize\GridPageSize;
use app\modules\UserManagement\models\rbacDB\Role;
use app\modules\UserManagement\models\User;
use app\modules\UserManagement\UserManagementModule;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\UserManagement\models\search\UserSearch $searchModel
 */

$this->title = UserManagementModule::t('back', 'Users');
$this->params['breadcrumbs'][] = $this->title;
$this->params['useContainer'] = false;
?>

<h2 class="lte-hide-title mt-4"><?= $this->title ?></h2>

<div class="panel panel-default">
	<div class="panel-body">

		<div class="row">
			<div class="col-sm-6">
				<p>
					<?= GhostHtml::a(
						'<span class="glyphicon glyphicon-plus-sign"></span> ' . UserManagementModule::t('back', 'Create'),
						['/user-management/user/create'],
						['class' => 'btn btn-success-old']
					) ?>
				</p>
			</div>

			<div class="col-sm-6 text-right">
				<?= GridPageSize::widget(['pjaxId' => 'user-grid-pjax']) ?>
			</div>
		</div>

		<?php Pjax::begin([
			'id' => 'user-grid-pjax',
		]) ?>

		<?= GridView::widget([
			'id' => 'user-grid',
			// 'options' => [
			// 	'class' => 'grid-view table-responsive'
			// ],
			'tableOptions' => [
				'class' => 'table table-striped table-bordered table-smx'
			],
			'dataProvider' => $dataProvider,
			'pager' => [
				'options' => ['class' => 'pagination pagination-sm'],
				'hideOnSinglePage' => true,
				'lastPageLabel' => 'Last',
				'firstPageLabel' => 'First',
			],
			'filterModel' => $searchModel,
			'layout' => '{items}<div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">{summary}' . GridBulkActions::widget([
				'gridId' => 'user-grid',
				'actions' => [
					Url::to(['bulk-activate', 'attribute' => 'status']) => GridBulkActions::t('app', 'Activate'),
					Url::to(['bulk-deactivate', 'attribute' => 'status']) => GridBulkActions::t('app', 'Deactivate'),
					'----' => [
						Url::to(['bulk-delete']) => GridBulkActions::t('app', 'Delete'),
					],
				],
			]) . '</div></div>',

			'columns' => [
				['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width:10px']],

				[
					'class' => StatusColumn::className(),
					'attribute' => 'superadmin',
					'visible' => Yii::$app->user->isSuperadmin ?? false,
				],

				[
					'attribute' => 'username',
					'value' => function (User $model) {
						return Html::a($model->username, ['view', 'id' => $model->id], ['data-pjax' => 0]);
					},
					'format' => 'raw',
				],
				// [
				// 	'attribute' => 'email',
				// 	'format' => 'raw',
				// 	'visible' => User::hasPermission('viewUserEmail'),
				// ],
				// [
				// 	'class' => StatusColumn::className(),
				// 	'attribute' => 'email_confirmed',
				// 	'visible' => User::hasPermission('viewUserEmail'),
				// ],
				[
					'format' => 'raw',
					'value' => function (User $model) {
						return GhostHtml::a('Login As', ['/user-management/auth/login-as', 'id' => $model->username], ["class" => "btn btn-default btn-sm nowrap"]);
					},
				],
				[
					'attribute' => 'gridRoleSearch',
					'filter' => ArrayHelper::map(Role::getAvailableRoles(Yii::$app->user->isSuperAdmin ?? false), 'name', 'description'),
					'value' => function (User $model) {
						return Html::tag('div', implode(', ', ArrayHelper::map($model->roles, 'name', 'description')), ['class' => 'nowrap']);
					},
					'format' => 'raw',
					'visible' => User::hasPermission('viewUserRoles'),
				],
				[
					'attribute' => 'registration_ip',
					'value' => function (User $model) {
						return Html::a($model->registration_ip, "http://ipinfo.io/" . $model->registration_ip, ["target" => "_blank"]);
					},
					'format' => 'raw',
					'visible' => User::hasPermission('viewRegistrationIp'),
				],
				[
					'value' => function (User $model) {
						return GhostHtml::a(
							UserManagementModule::t('back', 'Roles and permissions'),
							['/user-management/user-permission/set', 'id' => $model->id],
							['class' => 'btn btn-sm btn-primary nowrap', 'data-pjax' => 0]
						);
					},
					'format' => 'raw',
					'visible' => User::canRoute('/user-management/user-permission/set'),
					'options' => [
						'width' => '10px',
					],
				],
				[
					'value' => function (User $model) {
						return GhostHtml::a(
							UserManagementModule::t('back', 'Change password'),
							['change-password', 'id' => $model->id],
							['class' => 'btn btn-sm btn-default nowrap', 'data-pjax' => 0]
						);
					},
					'format' => 'raw',
					'options' => [
						'width' => '10px',
					],
				],
				[
					'class' => StatusColumn::className(),
					'attribute' => 'status',
					'optionsArray' => [
						[User::STATUS_ACTIVE, UserManagementModule::t('back', 'Active'), 'success'],
						[User::STATUS_INACTIVE, UserManagementModule::t('back', 'Inactive'), 'warning'],
						[User::STATUS_BANNED, UserManagementModule::t('back', 'Banned'), 'danger'],
					],
				],
				['class' => 'yii\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
				[
					'class' => yii\grid\ActionColumn::className(),
					'contentOptions' => ['class' => 'nowrap text-center'],
					// 'options' => ['style' => 'width: 100px;']
					// 'options' => ['class' => 'nowrap']
				],
			],
		]); ?>

		<?php Pjax::end() ?>

	</div>
</div>