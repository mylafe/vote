<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */

$this->title = '在线投票系统';
?>
<div class="site-index">

    <div class="col-lg-8">

        <div class="body-content">

        <div class="row">

            <div class="col-lg-12">
                <?php
                if (empty($voArray)) {
                        echo "</br>";
                        echo "<h2>暂无数据！</h2>";
                    }
                ?>
                
                <?php foreach($voArray as $vo):?>
                <div class="loop-container">
                    <h2><?=$vo['title']?></h2>
                    <h6>投票时间：<?=$vo['startime']?>到<?=$vo['endtime']?></h6>
                    <!-- <div class="content"><?= mb_substr(Html::decode($vo['content']), 0 , 100) ?></div> -->
                    <p class="content"><?=strip_tags(mb_substr($vo['content'], 0 , 100))?>。。。</p>
                    <p class="slimg"><img src="<?=$vo['label_img']?>" width="542" height="343"></p>
                    <p class="canyu"><a class="btn btn-default" href="<?=Url::toRoute(['site/list','id'=>$vo['id']])?>">参与投票 &raquo;</a></p>
                </div>
                <?php endforeach;?>

            </div>

            <!--分页-->
            <div class="f-r">
                <?= LinkPager::widget([
                    'pagination'=>$pages,
                    'firstPageLabel' => '首页',
                    'nextPageLabel' => '下一页',
                    'prevPageLabel' => '上一页',
                    'lastPageLabel' => '末页',
                ]) ?>
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
