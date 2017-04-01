<?php $baseUrl = Yii::app()->baseUrl;
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
    array(
      'name'=>'',
      'value'=>function($data,$row,$col){
        $tag=Yii::app()->baseUrl.'/file/img/forum/';
        if($data->to_top=='1')
          $tag=$tag.'top.png';
        elseif (isset($col->filterHtmlOptions['hmvn'])&&$data->views>=$col->filterHtmlOptions['hmvn'])
          $tag=$tag.'hot.png';
        elseif(strtotime($data->post_time) >= time() - 24 * 60 * 60) // post in 24hr
          $tag=$tag.'new.png';
        else
          return '';
        // echo '<img src="'.$tag.'" class="forum_article_list_title_pic" />';
        return CHtml::image($tag,'',
          array(
            'class'=>'forum_article_list_title_pic',
          )
        );
      },
      'filterHtmlOptions'=>array(
        'type'=>$type,
        'hmvn'=>isset($hmvn)?$hmvn:null,
      ),
      'type'  => 'raw',
      'htmlOptions'=>array(
        'class'=>'pic',
      ),
    ),
		array(
			'name'=>'分類',
			'value'=>'$data->sort->name',
      'htmlOptions'=>array(
        'class'=>'sortTag',
      ),
		),
		array(
			'name'=>'標題',
			'value'=>function($data,$row,$col){
        if(!isset($data))
          return false;
				return  CHtml::link (CHtml::encode($data->title),
                    '#',
            				array(
                      'onclick'=>'$.forum.openArticle('.$data->id.')',
            			  ),
                    array(
                      'class'=>'articleajaxlink',
                    )
                  );
			},
			'type'  => 'raw',
      'filterHtmlOptions'=>array(
        'type'=>$type,
        'hmvn'=>isset($hmvn)?$hmvn:null,
      ),
      'htmlOptions'=>array(
        'class'=>'title',
      ),
		),
    array(
      'name'=>'發表者',
      'value'=>'$data->auth->nickname',
      'htmlOptions'=>array(
        'class'=>'author',
      ),
    ),
    array(
      'name'=>'發佈時間',
      'value'=>function($data){
        $d = new DateTime($data->post_time);
        return $d->format("y-m-d");
      },
      'htmlOptions'=>array(
        'class'=>'time',
      ),
    ),
    array(
      'name'=>'回覆數/瀏覽數',
      'value'=>'count($data->comments)."/".$data->views',
      'htmlOptions'=>array(
        'class'=>'numOfView',
      ),
    ),
    // array(            // display a column with "view", "update" and "delete" buttons
    //     'class'=>'CButtonColumn',
    // ),
  ),
  'pager'=>array(
        'header'         => '',
        'firstPageLabel' => '',
        'prevPageLabel'  => '<img src="'.$baseUrl.'/file/img/forum/choser_left.png" />',
        'nextPageLabel'  => '<img src="'.$baseUrl.'/file/img/forum/choser_right.png" />',
        'lastPageLabel'  => '',
        'htmlOptions' => array('class'=>'forum_grid_view_pager'),
    ),
	'id'=>'article_grid_view_'.$type,
	'enableSorting' => false,
  'selectableRows'=>0,
  'summaryText' => '',
  'itemsCssClass'=>'forum_list_grid_view',
  'loadingCssClass'=>'',
)); ?>
