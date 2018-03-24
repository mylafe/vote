<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = '个人中心';
?>
<div class="site-index">

    <div class="col-lg-8">

        <div class="body-content">

        <div class="row">

            <div class="col-lg-12">

                <div class="loop-conleft">
                    <h4><i class="fa fa-address-card">昵称：</i><?=$data['username']?></h4>
                    <h4><i class="fa fa-envelope">邮箱：</i><?=$data['email']?></h4>
                    <h4><i class="fa fa-calendar-times-o">注册时间：</i><?= date('Y-m-d H:i:s',$data['created_at'])?></h4>
                    <h4><i class="fa fa-calendar-check-o">最后登录时间：</i><?= date('Y-m-d',$data['last_time'])?></h4>
                </div>

            </div>

        </div>

    </div>

    </div>
    <div class="col-lg-4">
        <div class="sb-widget">
            <div class="widget-content">
                <form action="<?=Url::toRoute('site/index')?>" class="searchform" id="searchform" method="post">
                    <div>
                        <input type="text" value="" placeholder="查找感兴趣的投票" name="keywords" required oninvalid="setCustomValidity('搜索内容不能为空')" oninput="setCustomValidity('')" id="keywords">
                        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                        <input type="submit" id="searchsubmit" value="搜索">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
