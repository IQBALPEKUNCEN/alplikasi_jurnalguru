<?php

namespace app\modules\UserManagement\controllers;

use app\modules\UserManagement\models\UserVisitLog;
use app\modules\UserManagement\models\search\UserVisitLogSearch;
use app\modules\UserManagement\components\basecomponents\AdminDefaultController;

/**
 * UserVisitLogController implements the CRUD actions for UserVisitLog model.
 */
class UserVisitLogController extends AdminDefaultController
{
	/**
	 * @var UserVisitLog
	 */
	public $modelClass = 'app\modules\UserManagement\models\UserVisitLog';

	/**
	 * @var UserVisitLogSearch
	 */
	public $modelSearchClass = 'app\modules\UserManagement\models\search\UserVisitLogSearch';

	public $enableOnlyActions = ['index', 'view', 'grid-page-size'];
}
