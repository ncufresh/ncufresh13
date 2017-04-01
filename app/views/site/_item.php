<?php
/* @var $this NewsController */
/* @var $data News */
?>

<div class="item">
	<div class="title">
	<?php echo CHtml::ajaxLink(
			CHtml::encode($data->title),
			Yii::app()->createUrl('site/news/'.$data->id),
			array(
					'type'=>'get',
					'beforeSend' => "function( request )
					                   	{
					                     // Set up any pre-sending stuff like initializing progress indicators
					                 	}",
					'complete'=> "function( request )
					                   	{
					                     // Set up any pre-sending stuff like initializing progress indicators
					                 	}",
					'success' => "function( data )
					                {
					                  // handle return data
					                  var box=$('<div class=\"news_view\"></div>').html(data);
				                  	  $.jumpWindow( box );
				                  	  box.children().css({
				                  	  	height: '+=50px'
				                  	  });
									  $.bar(box);
					              	}",
				),
			array(
					'class' => 'btn-link'
				)
			);

	
	?>
	</div>
	

	<div class="time"><?php echo CHtml::encode(date('m/d',strtotime($data->post_time))); ?></div>
</div>
	
<br />
