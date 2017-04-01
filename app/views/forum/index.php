<?php
/* @var $this ArticleController */
/* @var $dataProvider CActiveDataProvider */

?>

<?php  
  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'/app/js/forum/list.js');
  $cs->registerCssFile($baseUrl.'/css/forum.css');
  $cs->registerCssFile($baseUrl.'/css/main.css');
?>


<div class="forum_all_container">
	<?php echo Html::blockHead('forum_view_article_block','none',true);?>
	<?php echo Html::blockBottom('forum_view_article_block');?>
	<?php echo Html::blockHead('forum_new_post_block');?>
	<?php echo Html::blockBottom('forum_new_post_block');?>
	<?php if($initId!=0) {?>
	<div name="initView" id="<?php echo $initId;?>" style="display: none;"></div>
	<?php } ?>
	<?php echo Html::blockHead('forum_list_article_block', '');?>
		<div id="all_container">
			<!-- Title -->
			<div id="top_container">
				<div id="top_mid" class="forum_title">
					<!-- <img id="img_topic" class="forum_title_img" src="<?php echo $baseUrl;?>/file/img/forum/forum_title.png"/> -->
				</div>
			</div>
			<!-- Action bar -->
			<div class="action_row" class="forum_action_row" style="overflow: auto">

				<div id="top_left" class="forum_top_left">
					<div id="top_left_newpost" class="forum_new_post_btn_img_div">
						<img id="img_newpost" class="forum_new_post_img" src="<?php echo $baseUrl;?>/file/img/forum/new_post.png"/>
					</div>
				</div>

				<div id="top_right">
					<div id="top_right_search" class="forum_search_box">
						<?php $form=$this->beginWidget('CActiveForm', array(
							'action'=>'search.html',
							'id'=>'forum_search_form',
							'enableAjaxValidation'=>false,

						)); ?>
						<?php echo CHtml::textField('search_str','',array(
							'class'=>'forum_search_textField',
							'placeholder'=>'搜尋分類，作者，文章。Enter搜尋',
						)); ?>
						<?php //echo CHtml::submitButton('搜尋'); ?>
						<?php $this->endWidget(); ?>
					</div>
				</div>
			</div>
			<!-- Tag switch bar -->
			<div id="tag_row" class="forum_tag_row">
				<div id="body_ch1" class="forum_tag_div" type="all">
					<img class="forum_each_tag none" src="<?php echo $baseUrl;?>/file/img/forum/all_article.png" style="display: none;"/>
					<img class="forum_each_tag select" src="<?php echo $baseUrl;?>/file/img/forum/all_article_select.png"/>
					<img class="forum_each_tag hover" src="<?php echo $baseUrl;?>/file/img/forum/all_article_hover.png" style="display: none;"/>
				</div>
				<div id="body_ch2" class="forum_tag_div" type="hottest">
					<img class="forum_each_tag none" src="<?php echo $baseUrl;?>/file/img/forum/hottest.png"/>
					<img class="forum_each_tag select" src="<?php echo $baseUrl;?>/file/img/forum/hottest_select.png" style="display: none;"/>
					<img class="forum_each_tag hover" src="<?php echo $baseUrl;?>/file/img/forum/hottest_hover.png" style="display: none;"/>
				</div>
				<div id="body_ch3" class="forum_tag_div" type="newest">
					<img class="forum_each_tag none" src="<?php echo $baseUrl;?>/file/img/forum/newest.png"/>
					<img class="forum_each_tag select" src="<?php echo $baseUrl;?>/file/img/forum/newest_select.png" style="display: none;"/>
					<img class="forum_each_tag hover" src="<?php echo $baseUrl;?>/file/img/forum/newest_hover.png" style="display: none;"/>
				</div>
				<div id="body_ch4" class="forum_tag_div" type="search">
					<img class="forum_each_tag none" src="<?php echo $baseUrl;?>/file/img/forum/search.png"/>
					<img class="forum_each_tag select" src="<?php echo $baseUrl;?>/file/img/forum/search_select.png" style="display: none;"/>
					<img class="forum_each_tag hover" src="<?php echo $baseUrl;?>/file/img/forum/search_hover.png" style="display: none;"/>
				</div>
			</div>

			<div id="body_all">
				<div id="forum_body_inside" style="background: url(<?php echo $baseUrl;?>/file/img/forum/list_background.png) no-repeat;background-size: 100%; height 430px;">
					<div id="body_all_article" class="forum_list_box" type="all">
						<?php echo $this->renderPartial('_article_list', array(
							'dataProvider'=>$dataProvider,
							'type'=>'all',
							'hmvn'=>$hmvn
						)); ?>
					</div>
					<div id="body_hottest" class="forum_list_box" type="hottest">
					</div>
					<div id="body_newest" class="forum_list_box" type="newest">
					</div>
					<div id="body_search" class="forum_list_box" type="search">
						
					</div>

				</div>

			</div>
		</div>
	<?php echo Html::blockBottom('forum_list_article_block', '');?>
</div>
