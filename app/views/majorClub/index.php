<?php 
Yii::app()->clientScript->registerCoreScript('jquery');// import jquery
$cs=Yii::app()->clientScript;
$bUrl=Yii::app()->request->baseUrl;//the absolute baseUrl
$cs->registerScriptFile($bUrl.'/app/js/majorclub/majorclubIntro.js');// import js file
$cs->registerCSSFile($bUrl.'/css/major_club_style.css');// import css file

?>
<script>var bUrl = "<?=$bUrl;?>";</script>



<?php echo Html::blockHead('son2','none',true); ?>
<?php echo Html::blockBottom('son2'); ?>

<?php echo Html::blockHead('son1','none',true); ?>
<?php echo Html::blockBottom('son1'); ?>

<?php echo Html::blockHead('cnt','block');?>
<div class="subtitle"id="index_subtitle">
	<img src="<?php echo $bUrl?>/file/img/majorclub/majorclub_intro.png" />
</div>
<div class="majorclub_streamerlist" id="majorclub_layer1_catalog"style="background-image:url('<?php echo $bUrl?>/file/img/majorclub/index_bg.png');" >
	            <img class='first_button' src="<?php echo $bUrl?>/file/img/majorclub/m.png" alt="*" id="m"style="bottom:0px;" />
	            <img class='' src="<?php echo $bUrl?>/file/img/majorclub/stu.png" alt="*" id="stu" style="bottom:-55px;" />
	            <img class='first_button' src="<?php echo $bUrl?>/file/img/majorclub/c.png"alt="*" id="c"style="bottom:0px;" />
</div>

<?php echo Html::blockBottom('cnt','block');?>

<?php if($direct){ ?>
<script type="text/javascript">
	$(document).ready(function() {
		showSecondCatalog(<?php echo $first;?>);
		showList(<?php echo $second;?>);
		entries(<?php echo $e_name;?>);
	});
</script>
<?php }?>
