<?php

namespace app\models\base;

use Yii;
use yii\base\Security;

/**
 * This is the base model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $confirmation_token
 * @property integer $status
 * @property integer $superadmin
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $registration_ip
 * @property string $bind_to_ip
 * @property string $email
 * @property integer $email_confirmed
 *
 * @property \app\models\AuthAssignment[] $authAssignments
 * @property \app\models\AuthItem[] $itemNames
 * @property \app\models\UserVisitLog[] $userVisitLogs
 */
class User extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_BANNED = -1;

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames()
    {
        return [
            // 'authAssignments',
            // 'itemNames',
            // 'userVisitLogs'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'created_at', 'updated_at'], 'required'],
            [['status', 'superadmin', 'created_at', 'updated_at', 'email_confirmed'], 'integer'],
            [['username', 'password_hash', 'confirmation_token', 'bind_to_ip'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['registration_ip'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'confirmation_token' => 'Confirmation Token',
            'status' => 'Status',
            'superadmin' => 'Superadmin',
            'registration_ip' => 'Registration Ip',
            'bind_to_ip' => 'Bind To Ip',
            'email' => 'Email',
            'email_confirmed' => 'Email Confirmed',
        ];
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        if (php_sapi_name() == 'cli') {
            $security = new Security();
            $this->password_hash = $security->generatePasswordHash($password);
        } else {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
    }

    public function changePassword($new_password)
    {
        // set password hash
        $this->setPassword($new_password);
        // save perubahan
        return $this->save();
    }

    /**
     * @inheritdoc
     * @return \app\models\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\UserQuery(get_called_class());
    }
}
