<?php 
    $cs=Yii::app()->clientScript;
    $bUrl=Yii::app()->request->baseUrl;//the absolute baseUrl
    $dir_major_title= $bUrl."/file/img/majorclub/".$firstCatalog."_title.png"; //major title
    $dir_major_bg= $bUrl."/file/img/majorclub/".$firstCatalog."_bg.png"; // major background
    $dir_vector_left= $bUrl."/file/img/majorclub/left.png"; // left
    $dir_main= $bUrl."/file/img/majorclub/"; 
    $dir_vector_right= $bUrl."/file/img/majorclub/right.png"; // right
?> 
<div class="subtitle"id="second_subtitle">
<img src="<?php echo $dir_major_title;?>"firstCatalog="<?php echo $firstCatalog.'_title' ?>">
</div>
<div class="majorclub_streamerlist_outter-box"style="background-image:url(<?php echo $dir_major_bg;?>);margin-left:-20px;">
    <img src="<?php echo $dir_vector_left;?>" class="vector" id="vector_go_m">
    <div class="majorclub_streamerlist_inner-box"id="inner_box_m">
        <div class="majorclub_streamerlist_img" id="majorclub_layer2_quality_m"> 
            <?php foreach($second_pic_array as $secondCatalog => $pic ){?>
                <img src="<?php echo $dir_main. $pic; ?>.png" alt="*" cata="<?php echo $firstCatalog.$secondCatalog; ?>" id="second_cata<?php echo $firstCatalog.$secondCatalog; ?>"picname="<?php echo $pic ?>"class="second_button"style="bottom:0px;"/>
            <?php } ?>
        </div>
    </div>
    <img src="<?php echo $dir_vector_right;?>" class="vector" id="vector_back_m">
</div>
