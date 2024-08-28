<?php

namespace app\modules\UserManagement\controllers;

use app\modules\UserManagement\components\basecomponents\AdminDefaultController;
use app\modules\UserManagement\models\rbacDB\AuthItemGroup;
use app\modules\UserManagement\models\rbacDB\search\AuthItemGroupSearch;

/**
 * AuthItemGroupController implements the CRUD actions for AuthItemGroup model.
 */
class AuthItemGroupController extends AdminDefaultController
{
	/**
	 * @var AuthItemGroup
	 */
	public $modelClass = 'app\modules\UserManagement\models\rbacDB\AuthItemGroup';

	/**
	 * @var AuthItemGroupSearch
	 */
	public $modelSearchClass = 'app\modules\UserManagement\models\rbacDB\search\AuthItemGroupSearch';

	/**
	 * Define redirect page after update, create, delete, etc
	 *
	 * @param string       $action
	 * @param AuthItemGroup $model
	 *
	 * @return string|array
	 */
	protected function getRedirectPage($action, $model = null)
	{
		switch ($action) {
			case 'delete':
				return ['index'];
				break;
			case 'update':
				return ['view', 'id' => $model->code];
				break;
			case 'create':
				return ['view', 'id' => $model->code];
				break;
			default:
				return ['index'];
		}
	}
}
