<?php

namespace app\modules\UserManagement\components\widgets\TesWidget;

use yii\base\Widget;

class TesWidget extends Widget
{
    public $message = 'Hello, Tes 123456!';

    public function run()
    {
        return $this->render('index', [
            'message' => $this->message,
        ]);
    }
}
