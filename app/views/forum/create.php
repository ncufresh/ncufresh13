<?php  
  $baseUrl = Yii::app()->baseUrl;
 ?>

<div class="forum_new_post_title_row_bg" style="background: url(<?php echo $baseUrl;?>/file/img/forum/new_post/title_bg.png) no-repeat;"></div>
<div class="forum_new_post_content_bg" style="background: url(<?php echo $baseUrl;?>/file/img/forum/new_post/content_box_bg.png) no-repeat;background-size:100%;">
<?php echo $this->renderPartial('_form', array('model'=>$model, 'sort'=>$sort, 'sort_tag'=>$sort_tag)); ?>
</div>