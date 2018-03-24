<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$this->title = '投票详情页';
?>
<div class="site-index">

    <div class="col-lg-8">

        <div class="body-content">

        <div class="row">

            <div class="col-lg-12">

                <div class="loop-container opt">
                    <h2><?=$data['title']?></h2>
                    <h6>投票时间：<?=$data['startime']?>到<?=$data['endtime']?></h6>
                    <h6><?=$data['summary']?></h6>
                    <p class="content"><?=$data['content']?></p>
                    <p class="slimg"><img src="<?=$data['label_img']?>" width="542" height="343"></p>
                    <h4>投票选项</h4>
                    <div>

                     <!-- 检查是否登录 -->
                    <?php
                    if (Yii::$app->user->isGuest) {
                            echo "</br>";
                            echo "<h2>请先登录后，投票</h2>";
                        }
                    ?>

                    <?php $form = ActiveForm::begin(); ?>

                    <!-- 判断单选多选 -->
                    <?php
                    if (($data['type']) == 1) {
                    ?>
                        <!-- 单选 -->（单选）
                        <?php foreach($datainfo as $vo):?>
                        <input class="magic-radio" id="r<?=$vo['id']?>" type="radio" name="datatou" value="<?=$vo['id']?>" required><label for="r<?=$vo['id']?>"><?=$vo['votename']?></label>
                        <?php endforeach;?>
                    <?php
                    }else{
                    ?>
                        <!-- 多选 -->（多选）
                        <?php foreach($datainfo as $vo):?>
                        <input class="magic-checkbox" id="c<?=$vo['id']?>" type="checkbox" name="datatou[]" value="<?=$vo['id']?>" required><label for="c<?=$vo['id']?>"><?=$vo['votename']?></label>
                        <?php endforeach;?>
                    <?php
                        }
                    ?>
                    
                    <!-- 投票 选项不为空 没有投过票 非游客 显示 -->
                    <?php
                    if (!empty($datainfo) && empty($istou) && !(Yii::$app->user->isGuest) ){
                    ?>
                        <!-- 检查投票时间是否有效 -->
                        <?php
                        $strtime = strtotime($data['startime']);
                        $endtime = strtotime($data['endtime']);
                        if ($strtime<time()&&$endtime>time()) {
                        ?>
                            <div class="form-group" style="text-align:right">
                                <?= Html::submitButton('投票',['class' => 'btn btn-success','data-confirm' => '确认投票?']) ?>
                            </div>

                        <?php
                        }else{
                        ?>
                            <h2>不在有效投票时间内</h2>
                        <?php
                        }
                        ?>

                    <?php
                    }else{
                    ?>

                    <?php
                    }
                    ?>

                    <?php ActiveForm::end(); ?>
                    </div>
                    <!-- 检查是否有投票选项 -->
                    <?php
                    if (empty($datainfo)) {
                            echo "</br>";
                            echo "<h2>暂无投票选项！</h2>";
                        }
                    ?>
                    <!-- 检查是否有投票选项 -->
                    <?php
                    if (!empty($istou)) {
                            echo "</br>";
                            echo "<h2>您已经投过票了</h2>";
                        }
                    ?>

                    <!-- 投票后显示结果 对游客可见 -->
                    <?php
                    if (!empty($istou) || Yii::$app->user->isGuest) {
                    ?>
                    
                    <h4>投票结果</h4>
                    <?php foreach($res as $vo): error_reporting(E_ALL ^ E_WARNING); //关闭warning?>

                        <div class="skillbar clearfix " data-percent="<?=round(($vo['count']/$total*100),2)."%"?>">

                            <div class="skillbar-title" style="background: #d35400;"><span><?=$vo['votename']?></span></div>

                            <div class="skillbar-bar" style="background: #e67e22;"></div>

                            <div class="skill-bar-percent"><?=$vo['count']?>/<?=$total?>（<?=round(($vo['count']/$total*100),2)."%"?>）</div>

                        </div>

                    <?php endforeach;?>

                    <?php       
                        }
                    ?>

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

<script type="text/javascript">

$(document).ready(function(){

    $('.skillbar').each(function(){

        $(this).find('.skillbar-bar').animate({

            width:$(this).attr('data-percent')

        },1000);

    });

});

</script>
