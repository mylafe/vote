<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '投票列表';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <h1><?= Html::encode($this->title) ?></h1>
                    <div class="row">
                    <div class="col-sm-3">
                        <a class="btn btn-info btn-sm" href="<?= Url::toRoute('vote/create')?>">新增投票</a>
                    </div>
                    <div class="col-sm-3 pull-right">
                        <form action="<?=Url::toRoute('vote/list')?>" method="post">
                            <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->getRequest()->getCsrfToken();?>" />
                            <div class="input-group">
                                <input type="text" placeholder="请输入投票标题" name="title" class="input-sm form-control" required> <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-primary"> 搜索</button> </span>
                            </div>
                        </form>
                    </div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>标题</th>
                                <th>摘要</th>
                                <th>投票时间</th>
                                <th>发布时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                            if (empty($vote)) {
                                    echo "<h2>暂无数据！</h2>";
                                }
                            ?>

                            <?php foreach($vote as $vo):?>
                                <tr>
                                    <td><?=$vo['id']?></td>
                                    <td><?=$vo['title']?></td>
                                    <td><?=$vo['summary']?></td>
                                    <th><?=$vo['startime']?>至<?=$vo['endtime']?></th>
                                    <td><?= date('Y-m-d H:i:s',$vo['createtime'])?></td>
                                    <td><!-- <a class="btn btn-primary btn-xs" href="<?=Url::toRoute(['vote/update','id'=>$vo['id']])?>"><i class="fa fa-edit"></i>编辑</a> -->  <?php if($vo['votename'] !='admin'):?><a href="<?=Url::toRoute(['vote/delete','id'=>$vo['id']])?>" class="btn btn-default btn-xs"><i class="fa fa-close"></i>删除</a><?php endif;?></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                        <!--分页-->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
