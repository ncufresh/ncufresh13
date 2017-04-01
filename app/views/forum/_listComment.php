<?php
	$floor_num = $widget->dataProvider->getPagination()->currentPage * $widget->dataProvider->getPagination()->pageSize + $index + 2;
	Yii::app()->clientScript->scriptMap['jquery.js'] = false;
	Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;
	$baseUrl = Yii::app()->baseUrl;
	if(!Yii::app()->user->isGuest && Yii::app()->user->id===$data->auth_id)
		$is_author = true;
	else
		$is_author = false;
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>'UpdateComment/'.$data->id.'.html',
	'id'=>'forum_comment_edit_form',
	'htmlOptions'=>array(
		'cid'=>$data->id,
	),
	'enableAjaxValidation'=>false,

)); ?>	
<div id="article_detail" class="forum_article_view_content_box">

<div id="auth_detail" class="forum_article_view_auth_detail_box" style="background: url(<?php echo $baseUrl;?>/file/img/forum/article/comment_user_profile_bg.png) no-repeat;background-size: 100% 100%;">
	<div class="forum_article_view_floor"></div>
	<div class="forum_article_view_auth_detail_inner" cid="<?php echo $data->id;?>">
		<?php echo $floor_num;?>樓作者
		<a href="<?php echo $baseUrl;?>/profile/index/<?php echo $data->auth->uid;?>.html"><?php echo CHtml::encode($data->auth->nickname); ?></a>
	</div>
	<div class="forum_auth_head">
		<img src="<?php echo Html::getPersonalImgUrl($data->auth_id); ?>" />
	</div>
</div>

<div class="forum_artivle_view_content_box" style="background: url(<?php echo $baseUrl;?>/file/img/forum/article/comment_list_bg.png) no-repeat;background-size: 100%;">
	<?php if($is_author){?>
	<div cid="<?php echo $data->id;?>" class="forum_comment_delete forum_eff_btn" style="background: url(<?php echo $baseUrl; ?>/file/img/forum/delete.png) no-repeat; background-size: 100%;">
			
	</div>
	<?php }?>
	<div class="forum_article_view_scrollerBar">
		<div class="forum_scrollerBar forum_comment_view" cid="<?php echo $data->id;?>" style="height:100%;width:100%;">
			<div id="content_content" class="forum_article_view_content_inner forum_comment_view forum_content" cid="<?php echo $data->id;?>" style="float:left;top:0px;">
				<?php echo nl2br(CHtml::encode($data->content)); ?>
			</div>
		</div>
		<?php if($is_author){?>
		<div id="content_content" class="forum_article_view_content_inner_textfield forum_comment_edit" cid="<?php echo $data->id;?>" style="float:left;">
			<?php echo $form->textArea($data, 'content',
					array(
						'class'=>'forum_comment_edit_textField',
					)
				); ?>
		</div>
		<?php }?>
	</div>
	<?php if($is_author){?>
		<div cid="<?php echo $data->id;?>" class="forum_article_edit_btn_bar forum_comment_edit" style="float: right;">
			<button cid="<?php echo $data->id;?>" type="submit" class="btn forum_comment_edit_btn_submit forum_comment_edit" style="display: none;" onclick="">確定</button>
			<button cid="<?php echo $data->id;?>" type="reset" class="btn forum_comment_edit_btn_cancel forum_comment_edit" style="display: none;">取消</button>
		</div>
	<?php }?>
	<div cid="<?php echo $data->id;?>" id="content_detail" class="forum_article_view_content_detail_row forum_comment_view">
		<div class="nono" style="width: 30%;float: left;"></div>
		
		<div id="time" cid="<?php echo $data->id;?>" class="forum_comment_view" style="float: right;">
			<?php if(isset($data->update_time)){ ?>
				<p style="margin: 0px;">更新於: <?php echo CHtml::encode($data->update_time); ?></p>
			<?php }else{ ?>
				<p style="margin: 0px;">發佈於: <?php echo CHtml::encode($data->post_time); ?></p>
			<?php }?>
			
		</div>
		<?php if($is_author){?>
		<div id="edit" cid="<?php echo $data->id;?>" class="forum_comment_view" style="float: right;margin-right:30px;">
			<?php
				echo CHtml::link('Edit', "#", array(
						'class'=>'forum_comment_edit_link',
						'cid'=>$data->id,
					));
			?>
		</div>
		<?php }?>
	</div>
</div>

</div><?php $this->endWidget(); ?>
