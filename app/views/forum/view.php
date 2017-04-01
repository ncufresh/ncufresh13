
<?php
	$baseUrl = Yii::app()->baseUrl;
	if(!Yii::app()->user->isGuest && Yii::app()->user->id===$model->auth_id)
		$is_author = true;
	else
		$is_author = false;
?>
<?php
  Yii::app()->getClientScript()->scriptMap=array('script.js'=>Yii::app()->baseUrl.'/app/js/script.js');
?>
<?php $list = CHtml::listData($sort, 'id', 'name');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>'update/'.$model->id.'.html',
	'id'=>'forum_article_edit_form',
	'htmlOptions'=>array(
		'class'=>$model->id,
	),
	'enableAjaxValidation'=>false,

)); ?>
<div class="forum_article_view_title_row" aid="<?php echo $model->id;?>">
	<div class="forum_article_view_bg" style="background: url(<?php echo $baseUrl;?>/file/img/forum/article/title_bg.png) no-repeat;background-size: 100% 100%;">
		<div class="forum_article_view_title forum_article_view"><?php echo CHtml::encode($model->title); ?></div>
		<?php if($is_author){?>
		<div class="forum_article_edit_title_textField forum_article_edit" style="width: 60%;display:none;">
			<?php echo $form->textField($model,'title',array('style'=>''));
			?>
		</div>
		<div class="forum_article_edit_tag forum_article_edit" style="">
			<?php echo $form->dropDownList($sort_tag, 'id', $list, array('empty' => '分類'));?>
		</div>
		<?php }?>
	</div>
	<div class="forum_article_view_comment_btn forum_eff_btn">
		<img class="forum_article_view_comment_btn_img" src="<?php echo $baseUrl;?>/file/img/forum/article/btn_comment.png">
	</div>
</div>
<div id="article_detail" class="forum_article_view_content_box">
	<div id="auth_detail" class="forum_article_view_auth_detail_box" style="background: url(<?php echo $baseUrl;?>/file/img/forum/article/user_profile_bg.png) no-repeat;background-size: 100% 100%;">
		<div class="forum_article_view_floor"></div>
		<div class="forum_article_view_auth_detail_inner">
			1樓作者
			<a href="<?php echo $baseUrl;?>/profile/index/<?php echo $model->auth->uid;?>.html"><?php echo CHtml::encode($model->auth->nickname); ?></a>
			
		</div>
		<div class="forum_auth_head">
			<img src="<?php echo Html::getPersonalImgUrl($model->auth_id); ?>" />
		</div>
	</div>
	<div class="forum_artivle_view_content_box" style="background: url(<?php echo $baseUrl;?>/file/img/forum/article/content_bg.png) no-repeat;background-size: 100%;">
		<?php if($is_author){?>
		<div class="forum_article_delete forum_eff_btn" style="background: url(<?php echo $baseUrl; ?>/file/img/forum/delete.png) no-repeat; background-size: 100%;">
			
		</div>
		<?php }?>
		<div class="forum_article_view_scrollerBar">
			<div class="forum_scrollerBar forum_article_view" style="height:100%;width:100%;">
				<div id="content_content" class="forum_article_view_content_inner forum_article_view forum_content" style="float:left;top:0px;">
					<?php echo nl2br(CHtml::encode($model->content)); ?>
				</div>
			
			</div>
			<?php if($is_author){?>
			<div id="content_content" class="forum_article_view_content_inner_textfield forum_article_edit" style="float:left;display:none;">
				<?php echo $form->textArea($model, 'content',
					array(
						'class'=>'forum_article_edit_textField',
					)
				); ?>
			</div>
			<?php }?>
		</div>
		<?php if($is_author){?>
		<div class="forum_article_edit_btn_bar forum_article_edit" style="float:right;margin-right:12%;">
			<button type="submit" class="btn forum_article_edit_btn_submit forum_article_edit" style="display: none;" onclick="">確定</button>
			<button type="" class="btn forum_article_edit_btn_cancel forum_article_edit" style="display: none;">取消</button>
		</div>		
		<?php }?>
		<div id="content_detail" class="forum_article_view_content_detail_row forum_article_view">
			<div class="nono" style="width: 30%;float: left;"></div>
			
			<div id="time" class="forum_article_view" style="float: right;">
				<?php if(isset($model->update_time)){ ?>
					<p style="margin: 0px;">更新於: <?php echo CHtml::encode($model->update_time); ?></p>
				<?php }else{ ?>
					<p style="margin: 0px;">發佈於: <?php echo CHtml::encode($model->post_time); ?></p>
				<?php }?>
			</div>
			<?php if($is_author){?>
			<div id="edit" class="forum_article_view" style="float: right;margin-right:30px;">
				<?php
					echo CHtml::link('Edit', array('Update', 'id'=>$model->id), array(
						'class'=>'forum_article_edit_link',
					));
				?>
			</div>
			<?php }?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>


<?php
	// echo $grid;
	if(count($comments->getData())>0){
		$this->widget('zii.widgets.CListView', array(
			'id'=>'viewGridComment',
			'dataProvider'=>$comments,
			'itemsCssClass' => 'forum_view_article_comments_list',
			'itemView'=>'_listComment',
			// 'ajaxUpdate'=>null,
			'ajaxUrl'=>Yii::app()->createUrl('forum/view',array('id'=>$model->id)),
			// 'pagerCssClass'=>'pagination myp',
			'pager'=>array(
		        'header'         => '',
		        'firstPageLabel' => '',
		        'prevPageLabel'  => '<img class="forum_eff_btn" src="'.$baseUrl.'/file/img/forum/choser_left.png">',
		        'nextPageLabel'  => '<img class="forum_eff_btn" src="'.$baseUrl.'/file/img/forum/choser_right.png">',
		        'lastPageLabel'  => '',
		        'htmlOptions' => array('class'=>'forum_grid_view_pager', 'id'=>'0um_comment'),
	    	),
	    	'summaryText' => '',
	    	'loadingCssClass'=>'',
		));
	}
?>

<div class="forum_add_comment_form_box forum_article_view_content_box" style="background: url(<?php echo $baseUrl;?>/file/img/forum/article/comment_bg.png) no-repeat;background-size:100% 100%; display:none;">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl('forum/view',array('id'=>$model->id)),
//TODO: fixed url
			'id'=>'forum_add_comment_form',
			'enableAjaxValidation'=>false,
		)); ?>

		<p class="forum_article_edit_error_summary"></p>

		<?php echo $form->errorSummary($comment); ?>

		<div class="row">
			<label for="Comments_content" class="required">內容</label>
			<?php echo $form->textArea($comment,'content',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($comment,'content'); ?>
		</div>

		<div class="row buttons">
			<div id="forum_submit_btn" class="btn" type="submit" onclick="$('#forum_add_comment_form').submit()">回覆留言</div>
			<?php // echo CHtml::submitButton($comment->isNewRecord ? '回覆留言' : 'Save'); ?>
		</div>

	<?php $this->endWidget(); ?>
</div>
