<?php

namespace app\models\base;

use Yii;

/**
 * This is the base model class for table "token_session".
 *
 * @property string $token
 * @property string $expired_at
 * @property string $last_accessed
 */
class TokenSession extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames()
    {
        return [
            // ''
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token'], 'required'],
            [['expired_at', 'last_accessed'], 'safe'],
            [['token'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'token_session';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'token' => 'Token',
            'expired_at' => 'Expired At',
            'last_accessed' => 'Last Accessed',
        ];
    }

    public static function updateSession($token)
    {
        $model = self::findOne($token);
        if (!$model) {
            $model = new TokenSession();
            $model->token = $token;
        }

        // Jika waktu kedaluwarsa sudah lewat, return false
        if ($model->expired_at !== null && strtotime(date('Y-m-d H:i:s')) > strtotime($model->expired_at)) {
            return false;
        }

        $model->expired_at = date('Y-m-d H:i:s', strtotime("+15 minutes"));
        return $model->save(); // harusnya true, kalau false ya udah user ulang login
    }

    /**
     * @inheritdoc
     * @return \app\models\TokenSessionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\TokenSessionQuery(get_called_class());
    }
}
