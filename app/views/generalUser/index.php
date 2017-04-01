<?php
/* @var $this GeneralUserController */
/* @var $dataProvider CActiveDataProvider */

?>

<h1>General Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
