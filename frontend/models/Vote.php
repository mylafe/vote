<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
class Vote extends \yii\db\ActiveRecord
{   
    public $title;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote';
    }

    public function rules()
    {
        return [
            [['title','content','startime', 'endtime', 'orde', 'type', 'status'],'required'],
            [['summary', 'label_img'], 'string','max' => 255],
            // [['startime', 'endtime'],'date'],
        ];
    }

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
    
    //获取所有菜单列表
    public function  getAll(){
        $vote = Yii::$app->db->createCommand("SELECT * FROM `vote` ORDER BY id ASC ")->queryAll();
        return $vote;
    }
    
}
