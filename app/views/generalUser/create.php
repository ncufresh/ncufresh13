<?php
/* @var $this GeneralUserController */
/* @var $model GeneralUser */

$this->breadcrumbs=array(
	'General Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GeneralUser', 'url'=>array('index')),
	array('label'=>'Manage GeneralUser', 'url'=>array('admin')),
);
?>

<h1>Create GeneralUser</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>