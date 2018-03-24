<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

use kartik\datetime\DateTimePicker;

$this->title = '新增投票';
// $this->params['breadcrumbs'][] = ['label' => '投票','url' => ['vote/index']];
// $this->params['breadcrumbs'][] = $this ->title;
?>

<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h1>新增投票</h1>

            <hr/>

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'summary')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload',[
                'config'=>[
                ]
            ]) ?>

            <?= $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor',[
                'options'=>[
                    'initialFrameHeight' => 400,
                    //定制菜单
                    'toolbars' => [
                        [
                            'fullscreen', 'source', 'undo', 'redo', '|',
                            'fontsize',
                            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                            'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                            'forecolor', 'backcolor', '|',
                            'lineheight', '|',
                            'indent', '|'
                        ],
                    ]
                ]
            ]) ?>

            <?= $form->field($model, 'startime')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'format' => 'yyyy-m-dd h:i:s',
                        'autoclose' => true
                    ],
                ]);
            ?>

            <?= $form->field($model, 'endtime')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'format' => 'yyyy-m-dd h:i:s',
                        'autoclose' => true
                    ]
                ]);
            ?>
            
            <?php $model->orde = 0; ?>
            <?= $form->field($model, 'orde')->radioList([0=>否,time()=>是]) ?>

            <?php $model->type = 1; ?>
            <?= $form->field($model, 'type')->radioList([1=>单选,2=>多选]) ?>

            <?php $model->status = 1; ?>
            <?= $form->field($model, 'status')->radioList([0=>不显示,1=>显示]) ?>

            <div>
                <a href="#" id="AddMoreFileBox" class="btn btn-info">新增投票项</a></span></p>  
                <div id="InputsWrapper">  
                <div class="form-group"><input type="text" name="VoteInfo[votename][]" id="field_1" placeholder="选项 1"/><a href="#" class="removeclass">×</a></div>  
                </div> 
            </div>
            <br/>
            
            
            <div class="form-group">
                <?= Html::submitButton('发布', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<style type="text/css">
    #InputsWrapper input{
        width: 99%;
    }
</style>
<script>  
$(document).ready(function() {  
  
var MaxInputs       = 50; 
var InputsWrapper   = $("#InputsWrapper");   
var AddButton       = $("#AddMoreFileBox");  
  
var x = InputsWrapper.length;  
var FieldCount=1; 
  
$(AddButton).click(function (e)  
{  
        if(x <= MaxInputs)  
        {  
            FieldCount++;  
            $(InputsWrapper).append('<div class="form-group"><input type="text" name="VoteInfo[votename][]" id="field_'+ FieldCount +'" placeholder="选项 '+ FieldCount +'"/><a href="#" class="removeclass">×</a></div>');  
            x++;  
        }  
return false;  
});  
  
$("body").on("click",".removeclass", function(e){ 
        if( x > 1 ) {  
                $(this).parent('div').remove();  
                x--; 
        }  
return false;  
})   
  
});  
</script>  
