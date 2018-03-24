<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */

$this->title = '更新投票 ';
?>
<div class="wrapper wrapper-content">
    <div class="ibox-content">
        <div class="row pd-10">
            <h1><?= Html::encode($this->title) ?></h1>
            <hr>
            <div class="auth-item-form col-sm-4">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'title')->hiddenInput()->label('')?>

                <?= $form->field($model, 'summary')->textInput(['value'=>'<?=$vo['summary']?>'])->label('帐号') ?>

                <?= $form->field($model, 'content')->textInput(['value'=>''])->label('密码')?>
                <?= $form->field($model, 'proname')->hiddenInput()->label(false)?>

                <div class="form-group">
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>