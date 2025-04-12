<?php

use app\modules\UserManagement\components\GhostHtml;
use app\modules\UserManagement\models\rbacDB\Role;
use app\modules\UserManagement\models\User;
use app\modules\UserManagement\UserManagementModule;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\modules\UserManagement\models\User $model
 */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'User'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

	<h2 class="lte-hide-title"><?= $this->title ?></h2>

	<div class="panel panel-default">
		<div class="panel-body">

			<p>
				<?= GhostHtml::a(UserManagementModule::t('back', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
				<?= GhostHtml::a(UserManagementModule::t('back', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
				<?= GhostHtml::a('Login As', ['/user-management/auth/login-as', 'id' => $model->username], ["class" => "btn btn-default btn-sm nowrap"]); ?>
				<?= GhostHtml::a(
					UserManagementModule::t('back', 'Roles and permissions'),
					['/user-management/user-permission/set', 'id' => $model->id],
					['class' => 'btn btn-sm btn-info']
				) ?>

				<?= GhostHtml::a(UserManagementModule::t('back', 'Delete'), ['delete', 'id' => $model->id], [
					'class' => 'btn btn-sm btn-danger pull-right',
					'data' => [
						'confirm' => UserManagementModule::t('back', 'anda yakin ingin menghapus akun ini?'),
						'method' => 'post',
					],
				]) ?>
			</p>

			<?= DetailView::widget([
				'model'      => $model,
				'attributes' => [
					'id',
					[
						'attribute' => 'status',
						'value' => User::getStatusValue($model->status),
					],
					'username',
					[
						'attribute' => 'email',
						'value' => $model->email,
						'format' => 'email',
						'visible' => User::hasPermission('viewUserEmail'),
					],
					[
						'attribute' => 'email_confirmed',
						'value' => $model->email_confirmed,
						'format' => 'boolean',
						'visible' => User::hasPermission('viewUserEmail'),
					],
					[
						'label' => UserManagementModule::t('back', 'Roles'),
						'value' => implode('<br>', ArrayHelper::map(Role::getUserRoles($model->id), 'name', 'description')),
						'visible' => User::hasPermission('viewUserRoles'),
						'format' => 'raw',
					],
					[
						'attribute' => 'bind_to_ip',
						'visible' => User::hasPermission('bindUserToIp'),
					],
					array(
						'attribute' => 'registration_ip',
						'value' => Html::a($model->registration_ip, "http://ipinfo.io/" . $model->registration_ip, ["target" => "_blank"]),
						'format' => 'raw',
						'visible' => User::hasPermission('viewRegistrationIp'),
					),
					'created_at:datetime',
					'updated_at:datetime',
				],
			]) ?>

		</div>
	</div>
</div>