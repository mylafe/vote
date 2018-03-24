<?php
namespace frontend\models;

use yii\base\Model;
use Yii;

class Changepwd extends Model
{
    public $password;
    public $rePassword;
    public $verifyCode;
    public $auth_key;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','rePassword','auth_key'], 'required'],
            [['password','rePassword'], 'string', 'min' => 6],
            ['rePassword','compare','compareAttribute' => 'password','message' => '两次密码不一样'],

            ['verifyCode','captcha']
        ];
    }

    public function attributeLabels()
    {
        return[
            'password' => '新密码',
            'rePassword' => '重复密码',
            'verifyCode' => '验证码',
        ];
    }
}
