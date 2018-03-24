<?php
/**
 * 投票控制器
 */
namespace backend\controllers;

use backend\models\Vote;
use backend\models\VoteInfo;
use backend\models\VoteTou;
use yii\data\Pagination;
use backend\models\AuthAssignment;

use Yii;

class VoteController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction', 
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "",
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", 
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    //新增投票
    public function actionCreate()
    {
        $model = new Vote();
        $model2 = new VoteInfo();

        if ($model->load(Yii::$app->request->post())) {

            $model->createtime = time();
            $model->proname = Yii::$app->user->identity->username;
            // var_dump($model);exit;
            $model->save();
            $id = $model->id;//获取添加投票的id

            // 获取投票选项信息
            $model2->load($_POST);
            $data2 = $model2->attributes=$_POST['VoteInfo']['votename'];
            
            // 遍历存储
            foreach($data2 as $v){
                //var_dump($v);exit;
                $model2 = new VoteInfo();
                $model2 = clone $model2;
                $model2->vid = $id;
                $model2->votename = $v;
                $model2->save();
            }
            //var_dump($data2);exit;
            return $this->redirect(['list']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model2' => $model2
            ]);
        }
    }

    //更新投票
    public function actionUpdate(){
        $id = Yii::$app->request->get('id');//获取id
        $model = Vote::find()->where(['id' => $id])->one();//获取投票信息表
        $model2 = VoteInfo::find()->where(['vid' => $id])->all();//获取所有投票选项

        //更新保存操作
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            return $this->redirect(['vote/list']);
        }

        return $this->render('update',[
            'model' => $model,
            'model2' => $model2
        ]);
    }

    //投票列表
    public function actionList()
    {   
        // 搜索功能
        if (Yii::$app->request->post()) {
            if($_POST['title']!=''){
                $title = $_POST['title'];
                $data = Vote::find()->where(['like','title',$title]);//模糊搜索
                //var_dump($data);exit;
            }else{
                $data = Vote::find();
            }
            $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '10']);
            $vote = $data->offset($pages->offset)->limit($pages->limit)->asArray()->all();
            // var_dump($vote);exit;
            return $this->render('list',[
                'vote'=>$vote,
                'pages' => $pages
            ]);
        }

        $vote =Yii::$app->db->createCommand('select * from vote order by createtime DESC')->queryAll();
        // var_dump($voArray);exit;
        return $this->render('list', [
            'vote' => $vote
        ]);
    }

    //删除投票
    public function actionDelete($id)
    {
        $connection=Yii::$app->db;
        $transaction=$connection->beginTransaction();
        try
        {
            $connection->createCommand()->delete("vote", "id = '$id'")->execute();
            $connection->createCommand()->delete("vote_info", "vid = '$id'")->execute();//删除关联
            $connection->createCommand()->delete("vote_tou", "vid = '$id'")->execute();//删除关联
            $transaction->commit();
        }
        catch(Exception $ex)
        {
            $transaction->rollBack();
        }
        return $this->redirect(['list']);
    }

    protected function findModel($id)
    {
        if (($model = Vote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
