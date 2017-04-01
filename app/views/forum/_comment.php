<div class="row" id="box">

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('auth_id')); ?>:</b>
	<?php echo CHtml::encode($data->auth_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('post_time')); ?>:</b>
	<?php echo CHtml::encode($data->post_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	<?php echo CHtml::link('Edit', array('updateComment', 'id'=>$data->id)) ;?>
</div>