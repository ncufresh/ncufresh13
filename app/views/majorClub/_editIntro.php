<?php
$cs=Yii::app()->clientScript;
    
	$bUrl=Yii::app()->request->baseUrl;//the absolute baseUrl
	$cs->registerScriptFile($bUrl.'/app/js/script.js');
	$dir_get_pics= $bUrl."/file/majorclub_pictures/".$data['e_name']."/"; // http://localhost/....
	$box1_title_dir= $bUrl."/file/img/majorclub/box1_title.png"; // float window's title
	$delete_pic= $bUrl."/file/img/majorclub/delete1.png"; // delete btn
?>	
<div id="majorclub_body-subtitle">
	<h1><?php echo $data['c_name']; ?></h1>
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
			<!--form start-->
			<?php 
			$form=$this->beginWidget('CActiveForm', array(
				'id'                     =>'introForm',
				'htmlOptions'            =>array('class'=>'form-horizontal'),
			)); ?>
			<div class="content_intro"id="editform">
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'intro',array('class'=>"control-label")); ?>
					<?php echo $form->textArea($formModel,'intro',array('class'=>'input','cols'=>"65",'rows'=>"10")); ?>
					<?php echo $form->error($formModel,'intro'); ?>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'fb',array('class'=>"control-label")); ?>
					<?php echo $form->textField($formModel,'fb',array('class'=>'input','size'=>30,'maxlength'=>80)); ?>
					<?php echo $form->error($formModel,'fb'); ?>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'contact1_name',array('class'=>"control-label")); ?>
					<?php echo $form->textField($formModel,'contact1_name',array('class'=>'input','size'=>30,'maxlength'=>15)); ?>
					<?php echo $form->error($formModel,'contact1_name'); ?>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'contact1_fb',array('class'=>"control-label")); ?>
					<?php echo $form->textField($formModel,'contact1_fb',array('class'=>'input','size'=>30,'maxlength'=>80)); ?>
					<?php echo $form->error($formModel,'contact1_fb'); ?>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'contact1_email',array('class'=>"control-label")); ?>
					<?php echo $form->textField($formModel,'contact1_email',array('class'=>'input','size'=>30,'maxlength'=>30)); ?>
					<?php echo $form->error($formModel,'contact1_email'); ?>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'contact2_name',array('class'=>"control-label")); ?>
					<?php echo $form->textField($formModel,'contact2_name',array('class'=>'input','size'=>30,'maxlength'=>15)); ?>
					<?php echo $form->error($formModel,'contact2_name'); ?>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'contact2_fb',array('class'=>"control-label")); ?>
					<?php echo $form->textField($formModel,'contact2_fb',array('class'=>'input','size'=>30,'maxlength'=>80)); ?>
					<?php echo $form->error($formModel,'contact2_fb'); ?>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'contact2_email',array('class'=>"control-label")); ?>
					<?php echo $form->textField($formModel,'contact2_email',array('class'=>'input','size'=>30,'maxlength'=>30)); ?>
					<?php echo $form->error($formModel,'contact2_email'); ?>
				</div>
				<?php echo CHtml::activeHiddenField($formModel,'id'); ?>
				<?php echo CHtml::ajaxSubmitButton('完成編輯',
							Yii::app()->createUrl('majorClub/update'),
							array(
							'type'     => 'POST',
							'dataType' => 'JSON',
							'error'    => 'js:function(){
				                alertMsg(\'發生錯誤，請稍後再試\',"","error");
				            }',
							'success'  => 'js:function(data){
				                if(data.status=="success"){
				                	alertMsg("更新成功");
				            	}else{
				            		alertMsg("更新發生錯誤，請稍後再試","","error");
				            	}
				                $.jumpWindowClose();
				            }'
								));
				?>
			</div>
			<?php $this->endWidget(); ?>
			<!--form end-->
		</div>
		<div id="de_changepic">
		<div id="deletes">
<?php
		$j=0;
			foreach(array_slice($picArr, 2) as $thisData){
		$j++;
?>
		<div class="ch_pic_group"id="<?php echo 'ch_pic_group'.$j?>"style="position:relative;">
			<div class="ch_pic_n"id="<?php echo 'ch_pic'.$j ?>">
				<img src="<?php echo $dir_get_pics .$thisData ?>"id="<?php echo 'pic'.$j ?>"alt="no pic"style="width:120px;height:80px;"/>
			</div>

			<div class="overlap_thisdata" id="overlap_<?php echo $thisData ?>">
				<div class="delete_thisdata"id="delete_<?php echo $thisData ?>">
					<img src="<?php echo $delete_pic ?>"alt="no pic" />
				</div>
				<div class="delete_form_thisdata"id="delete_form_<?php echo $thisData ?>">
					<?php echo CHtml::form(Yii::app()->request->baseUrl.'/majorClub/delete.html');?>
					
						<input type="hidden"name="e_name"value="<?php echo $data['e_name'] ?>">
						<input type="hidden"name="picname"value="<?php echo $thisData ?>">
					<input type="submit" name="submit" value="d">
					<?php echo CHtml::endForm();?>
				</div>
			</div>
		</div>
<?php
			}
$upload_left=array(240,360,360,480,480,600);
?>
		</div>
			<div id="overlap"style="left:<?php echo $upload_left[$j].'px' ?>;">
				<div id="upload_field">
					<!-- simple upload file -->
					<?php
						if(count($picArr)<7){
							$form = $this->beginWidget(
							    'CActiveForm',
							    array(
							        'id' => 'upload-form',
							        'enableAjaxValidation' => false,
							        'htmlOptions' => array('enctype' => 'multipart/form-data','id'=>'overlap'),
							        'action'=>Yii::app()->createUrl('majorClub/uploadImage')
							    )
							);
							
								echo $form->fileField($imgModel, 'image');
								echo $form->error($imgModel, 'image');
								echo CHtml::activeHiddenField($formModel,'id');
								echo CHtml::submitButton('上傳');
							
							$this->endWidget();
						}
					?>
					<!-- end of upload file -->
				</div>
			</div>

	</div>
	<?php 
	if(!empty($picArr[2])){
		?>
		<div id="majorclub_pictures">
			<img src="<?php if(empty($picArr[2])){$picArr[2]='no 2';} echo $dir_get_pics.$picArr[2] ?>"alt="no pic" />
		</div>
		<?php
	}
	?>
	</div>
</div>
