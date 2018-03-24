<?php

namespace backend\models;

use Yii;
use backend\models\AuthAssignment;

class VoteInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_info';
    }

    /**
     * @inheritdoc
     */
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
