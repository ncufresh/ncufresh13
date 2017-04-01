<?php
/* @var $this NewsController */
/* @var $data News */
?>


<div class="news_view_in">
	<div class="header">
		<h4><?php echo CHtml::encode($data->title); ?></h4>
		<div class="time">時間:<?php echo CHtml::encode($data->post_time); ?></div>
		<div class="author">作者:<?php echo CHtml::encode($data->auth->nickname); ?></div>
	</div>
	<?php if(Yii::app()->user->getState('admin')==1){?>
					<a href="<?php echo Yii::app()->createUrl('site/editNews/'.$data->id);?>">Edit</a>
	<?php }?>
	<div class="news_content">
		<div class="news_body">
			<p class="text"><?php echo Yii::app()->format->formatNtext($data->content); ?></p>
		</div>
	</div>
</div>

