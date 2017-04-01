<?php
   /* this view will display the entries according to different qualities of catalog(major,stu,club)  */
    $cs=Yii::app()->clientScript;
	$bUrl=Yii::app()->request->baseUrl;//the absolute baseUrl
?>
<div class="subtitle"id="entries_subtitle">
<img src="<?php echo $bUrl?>/file/img/majorclub/<?php echo $catalog ?>_title.png"catalog="<?php echo $catalog.'_title' ?>">
</div>
<div class="majorclub_streamerlist_outter-box"style="background-image:url('<?php echo $bUrl?>/file/img/majorclub/<?php echo $catalog ?>_bg.png');margin-left:-30px;">
<img src="<?php echo $bUrl?>/file/img/majorclub/left.png" class="vector_entry" id="entry_go">
    <div class="majorclub_streamerlist_inner-box"id="inner_box_en">
        <div class="majorclub_streamerlist_img" id="majorclub_layer3_entry"> 
        <?php foreach($data as $index => $e_name ){ ?>    
            <img src="<?php echo $bUrl?>/file/img/majorclub/<?php echo $e_name ?>.png" alt="*" style="position:relative;" e_name=<?php echo $e_name;?> class="list_button" />
        <?php } ?>              
        </div>
    </div>
<img src="<?php echo $bUrl?>/file/img/majorclub/right.png" class="vector_entry" id="entry_back">
</div>