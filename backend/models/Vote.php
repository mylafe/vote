<?php

namespace backend\models;

use Yii;
use backend\models\AuthAssignment;

class Vote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','content','startime', 'endtime', 'orde', 'type', 'status'],'required'],
            [['summary', 'label_img'], 'string','max' => 255],
            // [['startime', 'endtime'],'date'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'summary' => '摘要',
            'content' => '内容',
            'label_img' => '缩略图',
            'cat_id' => '分类id',
            'proname' => '发布者',
            'status' => '是否显示',
            'orde' => '置顶',
            'startime' => '开始时间',
            'endtime' => '结束时间',
            'type' => '方式',
        ];
    }


}
