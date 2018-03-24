<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
class VoteInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_info';
    }

    public function rules()
    {
        return [
            [['vid','votename'],'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'votename' => '投票选项',
        ];
    }
    
}
