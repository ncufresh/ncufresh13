<?php
/* @var $this GeneralUserController */
/* @var $model GeneralUser */

$this->breadcrumbs=array(
	'General Users'=>array('index'),
	$model->uid,
);

$this->menu=array(
	array('label'=>'List GeneralUser', 'url'=>array('index')),
	array('label'=>'Create GeneralUser', 'url'=>array('create')),
	array('label'=>'Update GeneralUser', 'url'=>array('update', 'id'=>$model->uid)),
	array('label'=>'Delete GeneralUser', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->uid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GeneralUser', 'url'=>array('admin')),
);
?>

<h1>View GeneralUser #<?php echo $model->uid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'uid',
		'username',
		'password',
	),
)); ?>
