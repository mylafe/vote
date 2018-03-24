<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Vote;
use frontend\models\User;
use frontend\models\VoteInfo;
use frontend\models\VoteTou;
use frontend\models\Changepwd;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * *首页
     * @return [type] [description]
     */
    public function actionIndex()
    {
        // $vote = new Vote();
        // $vote = $vote->getAll();

        // return $this->render('index', [
        //     'vote' => $vote
        // ]);
        // 搜索功能
        if (Yii::$app->request->post()) {
            if($_POST['keywords']!=''){
                $keywords = $_POST['keywords'];
                $voArray = Yii::$app->db->createCommand('select * from vote where status = 1 and title like concat("%", "'.$keywords.'", "%")  order by orde DESC , createtime DESC')->queryAll();//模糊搜索
                
                $data = Vote::find();
                $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '1000']);
            }else{
                $voArray = Yii::$app->db->createCommand('select * from vote where status = 1 order by orde DESC , createtime DESC')->queryAll();
                
                $data = Vote::find();
                $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '1000']);
            }
            return $this->render('index',[
                'voArray'=>$voArray,
                'pages' => $pages
            ]);
        }

        //首页数据
        //$voArray =Yii::$app->db->createCommand('select * from vote where status = 1 order by orde DESC , createtime DESC')->queryAll();
        // var_dump($voArray);exit;
        $data = Vote::find();
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '5']);
        $voArray = $data->where(['status'=>'1'])->orderBy(['orde'=>SORT_DESC,'createtime'=>SORT_DESC])->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        return $this->render('index', [
            'voArray' => $voArray,
            'pages' => $pages
        ]);
    }

    // 投票详情
    public function actionList()
    {   
        // 投票详情
        if (Yii::$app->request->get()) {
            if($_GET['id']!=''){
                $model = new VoteInfo();
                $id = $_GET['id'];
                $name = Yii::$app->user->identity->username;
                // var_dump($id);exit;
                $data = Vote::find()->where(['id'=>$id])->asArray()->one();//投票详情
                $datainfo = VoteInfo::find()->where(['vid'=>$id])->asArray()->all();//投票选项详情

                $istou = VoteTou::find()->where(['vid'=>$id,'name'=>$name])->asArray()->all();//vote_tou是否已经存在对应id name ip数据 防止刷票
                $res = VoteInfo::find()->where(['vid'=>$id])->asArray()->all();//读取投票结果
                $total = VoteInfo::find()->where(['vid'=>$id])->sum("count");//对应投票总数
                //$datainfo =Yii::$app->db->createCommand('select * from vote_info where vid = '.$id.'')->queryAll();
                //var_dump($res);exit;
            }
        // 投票
        if (Yii::$app->request->post()&&empty($istou)&&Yii::$app->request->get()) {
                $model = new VoteInfo();
                $model2 = new VoteTou();
                // 写入投票
                // 获取投票选项信息
                $model->load($_POST);
                $id = $model->attributes=$_POST['datatou'];//投票选项id
                //var_dump($id);exit;

                $vtid = $_GET['id'];//投票id

                // 多选数据保存 array 
                if(is_array($id)){
                    // 遍历存储
                    foreach($id as $v){
                        //var_dump($v);exit;
                        $id = $v;
                        $tou =Yii::$app->db->createCommand('UPDATE `vote_info` SET count = count+1 WHERE `id`="'.$id.'"');
                        $tou->execute();//执行更新操作
                    }
                    }else{
                        $tou =Yii::$app->db->createCommand('UPDATE `vote_info` SET count = count+1 WHERE `id`="'.$id.'"');
                        //var_dump($tou);exit;
                        $tou->execute();//执行更新操作
                    }

                //写入投票人信息
                $name = Yii::$app->user->identity->username;
                $ip = $model2->getUserHostAddress();

                $model2->vid=$vtid;
                $model2->name=$name;
                $model2->ip=$ip;
                //var_dump($model2);exit;
                $model2->save();
                //var_dump($model2);exit;
                //$istou = VoteTou::find()->where(['vid'=>$id,'name'=>$name])->asArray()->all();//vote_tou是否已经存在对应id name ip数据 防止刷票
                
                //ar_dump($total);exit;
                $this->refresh();//投票成功 重新载入
                
            }

            return $this->render('list',[
                'data'=>$data,
                'datainfo'=>$datainfo,
                'istou'=>$istou,
                'res'=>$res,
                'total'=>$total,
            ]);
            
        }

        return $this->render('list');
    }

    /**
     * *个人中心
     * @return [type] [description]
     */
    public function actionPercenter()
    {   
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $username = Yii::$app->user->identity->username;
        // var_dump($username);exit;
        $data = User::find()->where(['username'=>$username])->asArray()->one();
        // var_dump($data);exit;
        return $this->render('percenter',[
                'data'=>$data
            ]);
    }

    /**
     * 修改密码
     */
    public function actionChangepwd()
    {   
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Changepwd();

        if ($model->load(Yii::$app->request->post())) {

            //更新密码
            exit;
            if(!empty($post['Changepwd']['auth_key_new'])){
                $username = Yii::$app->user->identity->username;//获取用户

                $model->setPassword($post['Changepwd']['auth_key_new']);
                $model->generateAuthKey();
            }else{
                $model->auth_key = $post['Changepwd']['auth_key'];
            }
            $model->save($post);

            return $this->redirect(['list']);
        } else {
            return $this->render('changepwd', [
                'model' => $model
            ]);
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            // 更新登录时间
            //$user = new User();
            $username = Yii::$app->user->identity->username;
            // var_dump($username);exit;
            $last_time = time();
            //$user->save()->where(['username' => $username]);
            $user =Yii::$app->db->createCommand('UPDATE user SET last_time='.$last_time.' WHERE `username`="'.$username.'"');
            //var_dump($user);exit;
            $user->execute();

            $isadmin = User::find()->where(['username'=>$username])->asArray()->one();//查询登录的isadmin
            // var_dump($isadmin['isadmin']);exit;
            if ($isadmin['isadmin'] == '1') {
                return $this->redirect('/backend/web/');
            }else{
                return $this->goBack();
            }

            // return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
