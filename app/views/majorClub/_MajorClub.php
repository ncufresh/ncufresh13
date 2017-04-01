<?php
$cs=Yii::app()->clientScript;
    
	$bUrl=Yii::app()->request->baseUrl;//the absolute baseUrl
	$cs->registerScriptFile($bUrl.'/app/js/script.js');
	$dir_get_pics= $bUrl."/file/majorclub_pictures/".$data['e_name']."/"; // http://localhost/....
	$box1_title_dir= $bUrl."/file/img/majorclub/box1_title.png"; // float window's title
	$delete_pic= $bUrl."/file/img/majorclub/delete1.png"; // delete btn
	$formate=new CFormatter;
?>	
<div id="majorclub_body-subtitle">
	<h1><?php echo CHtml::encode($data['c_name']) ?></h1>
	<img src="<?php echo $box1_title_dir ?>">
</div>
<div id="bg_color">
</div>
<div id="img_bg">
	<img src="" />
</div>
<div id="majorclub_dialog" >
	<div id="majorclub_wrap">
		<div id="majorclub_body-content">
		<div class="content_intro">
			<p>
				<?php 
				$intro =$data['intro']; 
				if($editable){
					echo '<br /><a href="#" id="edit" e_name='.$data['e_name'].'>編輯</a>';
				}
				if(!empty($intro)){
					echo '<br />'.$formate->formatNtext($intro); // put content to preview
				}else{
					echo '<br />查無介紹資料。';
				}
				?>
				<br />
			</p>
		</div>

		<div id="de_changepic">
		<?php
?>
		<div id="deletes">
<?php
		$j=0;
			foreach(array_slice($picArr, 2) as $thisData){
		$j++;
		$left=$j*95.5;
?>
		<div class="ch_pic_group"id="<?php echo 'ch_pic_group'.$j?>"style="position:relative;">
			<div class="ch_pic_n"id="<?php echo 'ch_pic'.$j ?>">
				<img src="<?php echo $dir_get_pics .$thisData ?>"id="<?php echo 'pic'.$j ?>"alt="no pic"style="width:120px;height:80px;"/>
			</div>
		</div>
			
<?php
			}
?>
		</div>

	</div>
	<?php 
if(!empty($picArr[2])){
	?>
		<div id="majorclub_pictures">
			<img src="<?php if(empty($picArr[2])){$picArr[2]='no 2';} echo $dir_get_pics.$picArr[2] ?>"alt="no pic" />
		</div>
			<?php
}else{echo '查無圖片';}
?>
	<div class="content_intro">
		<p>
			社團FB :<?php if(!empty($data['fb'])){ ?><a href="<?php echo CHtml::encode($data['fb']) ?>" target="_blank"><?php echo CHtml::encode($data['c_name']) ?></a><?php }?><br />
			聯絡人 : 		
			<?php if(!empty($data['contact1_fb'])){ ?>
			<a href="<?php echo CHtml::encode($data['contact1_fb']) ?>" target="_blank">
			<?php } ?>
			<?php echo CHtml::encode($data['contact1_name']) ?>	
			<?php if(!empty($data['contact1_fb'])){ ?>
			</a>
			<?php } ?>
			<br />		
			email : <?php echo CHtml::encode($data['contact1_email']) ?><br />		
			聯絡人 :
			<?php if(!empty($data['contact2_fb'])){ ?>
			<a href="<?php echo CHtml::encode($data['contact2_fb']) ?>" target="_blank">
			<?php } ?>
			<?php echo CHtml::encode($data['contact2_name']) ?>	
			<?php if(!empty($data['contact2_fb'])){ ?>
			</a>
			<?php } ?>
			<br />					
			email : <?php echo CHtml::encode($data['contact2_email']) ?><br />	
		</p>
	</div>
			</div>
	</div>
</div>
