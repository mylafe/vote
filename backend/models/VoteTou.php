<?php

namespace backend\models;

use Yii;
use backend\models\AuthAssignment;

class VoteTou extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'votetou';
    }

    /**
     * @inheritdoc
     */
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
            'ip' => 'ip',
        ];
    }


}
