<?php
/* @var $this GeneralUserController */
/* @var $model GeneralUser */

$this->breadcrumbs=array(
	'General Users'=>array('index'),
	$model->uid=>array('view','id'=>$model->uid),
	'Update',
);

$this->menu=array(
	array('label'=>'List GeneralUser', 'url'=>array('index')),
	array('label'=>'Create GeneralUser', 'url'=>array('create')),
	array('label'=>'View GeneralUser', 'url'=>array('view', 'id'=>$model->uid)),
	array('label'=>'Manage GeneralUser', 'url'=>array('admin')),
);
?>

<h1>Update GeneralUser <?php echo $model->uid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>