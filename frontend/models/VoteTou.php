<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
class VoteTou extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_tou';
    }

    public function rules()
    {
        return [
            [['vid','name','ip'],'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'vid' => '投票title',
            'name' => '投票人',
            'ip' => 'iP',
        ];
    }

    //获取用户ip
    public function getUserHostAddress()
    {
      switch(true){
        case ($ip=getenv("HTTP_X_FORWARDED_FOR")):
          break;
        case ($ip=getenv("HTTP_CLIENT_IP")):
          break;
        default:
      $ip=getenv("REMOTE_ADDR")?getenv("REMOTE_ADDR"):'127.0.0.1';
    }
    if (strpos($ip, ', ')>0) {
      $ips = explode(', ', $ip);
      $ip = $ips[0];
    }
      return $ip;
    }
    
}
