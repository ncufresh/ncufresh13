<?php
/* @var $this GeneralUserController */
/* @var $formModel GeneralUser */
/* @var $form CActiveForm */
?>



<div class="form">

	<?php
	CHtml::$afterRequiredLabel = '';
	CHtml::$beforeRequiredLabel = '';
	$form=$this->beginWidget('CActiveForm', array(
		'id'                     =>'login-form',
		'enableAjaxValidation'   =>false,
		'enableClientValidation' =>false,
		'action'                 =>Yii::app()->createUrl('site/login'),
	)); ?>
	<?php echo CHtml::link('',
		Yii::app()->createUrl('site/register'),
		array(
			'id' => 'register'
		)
	);?>
	<?php echo CHtml::ajaxLink( '',
		Yii::app()->createUrl('site/login'),
		array(
			'type'     => 'POST',
			'dataType' => 'json',
			'error'    => 'js:function(){
                alert(\'error\');
            }',
			'success'  => 'js:function(data){
                if(data.login==\'success\'){
                	$("#head_login").html(data.profile);
                	alertMsg("登入成功","登入:");
                	$("#head_login").trigger("login",data);

            	}else if(data.login==\'fail\'){
            		alertMsg("登入失敗，請檢查帳號密碼","登入:","error");
            	}else{
            		$("#message").html(\'請勿重複登入\');
            	}
            }',

		),
		array(
			'id' => 'login'
		)
	);
	?>


	<div class="row">
		<?php echo $form->textField($formModel,'username',array(
			'class'       =>'input-small',
			'placeholder' =>'帳號',
			'id' => 'username'
		)); ?>
	</div>

	<div class="row">
		<?php echo $form->passwordField($formModel,'password',array(
			'class'       =>'input-small',
			'placeholder' =>'密碼',
			'id' => "password"
		)); ?>
	</div>
	<div id="message"></div>
	<div class="row buttons">


	</div>

	<?php $this->endWidget(); ?>
	<script>
	$(function() {
	    $("#login-form input").keypress(function(event){       
	        if (event.keyCode == 13) $("#login").click();
	    });
	});
	</script>

</div><!-- form -->