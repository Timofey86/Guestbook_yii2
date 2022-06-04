<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property string|null $token
 * @property string|null $auth_key
 * @property string $date_add
 *
 * @property Feedback[] $feedbacks
 */
class Users extends ActiveRecord implements IdentityInterface
{
    public $password;
    public $password_confirm;
    public $rememberMe = true;

    const SCENARIO_AUTH = 'auth_scenario';
    const SCENARIO_REGISTER = 'register_scenario';

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return array_merge([
            [['name', 'email', 'password_hash'], 'required'],
            [['date_add','updated_at'], 'safe'],
            [['name', 'email', 'token', 'auth_key'], 'string', 'max' => 150],
            [['password_hash'], 'string', 'max' => 300],
            ['password', 'required', 'on' => self::SCENARIO_REGISTER],
            [['email', 'name', 'password'], 'trim'],
            ['email','getUser', 'on' => self::SCENARIO_AUTH],
            ['password', 'validatePassword','on' => self::SCENARIO_AUTH],
            ['password_confirm', 'compare', 'compareAttribute' => 'password',
                'message' => 'Пароли должны совпадать'],
            ['password', 'match', 'pattern' => '(^(?xi)
                (?=(?:.*[0-9]){2})
                (?=(?:.*[a-z]){2})
                .{6,}$
              )',
                'message' => 'Пароль должен быть 6 символов и содержать минимум 2 цифры', 'on' => self::SCENARIO_REGISTER],
            ['email', 'email'],
            ['email', 'exist', 'on' => self::SCENARIO_AUTH],
            [['email'], 'unique', 'on' => self::SCENARIO_REGISTER],
        ], parent::rules());
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'token' => Yii::t('app', 'Token'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'date_add' => Yii::t('app', 'Date Add'),
            'password' => Yii::t('app', 'Password'),
            'updated_at' => Yii::t('app','Updated At'),
            'password_confirm' => Yii::t('app', 'Password Confirm')
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at', 'date_add'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()')
            ],
        ];

    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::class, ['user_id' => 'id']);
    }

    public function getUsername()
    {
        return $this->name;
    }

    public function setAuthScenario()
    {
        $this->setScenario(self::SCENARIO_AUTH);
    }

    public function setRegisterScenario()
    {
        $this->setScenario(self::SCENARIO_REGISTER);
    }

    public static function findIdentity($id)
    {
        return Users::find()->andWhere(['id' => $id])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
    }

    public function getUser($attribute)
    {
        if ( !Users::findOne(['email' => $this->email])){
            $this->addError('email', 'Пользователь не найден!');
            return false;
        }
        return Users::findOne(['email' => $this->email]); // а получаем мы его по введенному логину
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) // если нет ошибок в валидации
        {

            $user = $this->getUser($attribute);

            if (!$user->checkPassword($this->password, $user->password_hash)) {

                $this->addError($attribute, 'Пароль введен неверно!!');
            }
        }
    }

    private function checkPassword($password, $password_hash)
    {
        return \Yii::$app->security->validatePassword($password, $password_hash);
    }

    public static function getListName():array
    {
        return ArrayHelper::map(self::find()->all(),'id','name');
    }

//    public function login()
//    {
//        if ($this->validate()) {
//            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
//        }
//        return false;
//    }
//
//    public function getUser()
//    {
//        if ($this->_user === false) {
//            $this->_user = Users::findByUsername($this->username);
//        }
//
//        return $this->_user;
//    }

}

