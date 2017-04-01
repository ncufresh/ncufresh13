<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */
$baseUrl = Yii::app()->baseUrl;
?>

<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'article_form',
		'enableAjaxValidation'=>false,
	)); ?><?php $list = CHtml::listData($sort, 'id', 'name');?>

	<div id="form_box" class="forum_new_post_form_box">
		<div id="form_top" class="forum_new_post_form_top">
			<div id="sort_tag" class="forum_create_article_sort_tag" style="float: left; width: 10%;">
				<?php echo $form->dropDownList($sort_tag, 'id', $list, array('empty' => '分類')); ?>
			</div>
			<div class="forum_new_post_form_title" style="float: left; width: 86%;padding-left: 10px;">
				<?php echo $form->textField($model,'title',array('style'=>'width: 100%', 'placeholder'=>'請輸入標題', 'id'=>'new_post_title')); ?>
			</div>
		</div>
		<div class="forum_new_post_form_content">
			<div class="error_summary">
				<?php echo $form->errorSummary($model); ?>
			</div>
			<div id="content_input" class="forum_new_post_content_textarea">
				<?php echo $form->textArea($model,'content',array('style'=>'height: inherit;')); ?>
			</div>
			<div class="error_input">
				<?php echo $form->error($model,'content'); ?>
			</div>
		</div>
	</div>
	<div class="forum_new_post_btn_row" id="ajax_submit">
		<button type="reset" class="forum_new_post_btn forum_eff_btn" style="background-color: transparent; border: 0;"><img class="forum_new_post_btn_img" src="<?php echo $baseUrl;?>/file/img/forum/new_post/btn_cancel.png"></button>
		<button type="submit" class="forum_new_post_btn forum_eff_btn" style="background-color: transparent; border: 0;"><img class="forum_new_post_btn_img" src="<?php echo $baseUrl;?>/file/img/forum/new_post/btn_submit.png"></button>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->