<?php
/* @var $this SiteController */
/* @var $dataProvider CArrayDataProvider */
?>


<?php
	echo Html::blockHead('news','block');
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'     =>$dataProvider,
		'itemView'         =>'_item',
		'summaryText'      =>'',
		'ajaxUpdate'       =>false,
		'enablePagination' =>false,
		'pagerCssClass'    => 'result-list',
	));
	$this->widget('CLinkPager', array(
		'header'         => '',
		'firstPageLabel' => '&lt;&lt;',
		'prevPageLabel'  => '&lt;',
		'nextPageLabel'  => '&gt;',
		'lastPageLabel'  => '&lt;&lt;',
		'pages'          => $pages,
	));
	echo Html::blockBottom('news','block');
?>


