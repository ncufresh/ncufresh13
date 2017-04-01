<?php
	$cs=Yii::app()->clientScript;
	$bUrl=Yii::app()->request->baseUrl;
	$cs->registerCSSFile($bUrl.'/css/video.css');
	$cs->registerScriptFile($bUrl.'/app/js/video/video.js');
	$cs->registerScriptFile($bUrl.'/app/js/video/jquery.video.js');
	if(isset($vidnow))
		$vidnow = "var vidnow = '".$vidnow."';";
	else
		$vidnow = "var vidnow = 'C8J6u9HEcrA';";
	$cs->registerScript('user', $vidnow, CClientScript::POS_HEAD);
?>

<?php  echo Html::blockHead('cnt','block');?>
	<div id="videoall">
		<div id="video">
			<div id="viddisplay" >
				<?php echo CHtml::image($bUrl.'/file/img/video/video.png','img fuck',array('id'=>'viddisplayimg')); ?> 
				<div id='viddisplayin'></div>
			</div >
			<div id="vidinfo">
				<?php echo CHtml::image($bUrl.'/file/img/video/vidinto.png','img fuck',array('id'=>'vidinfoimg')); ?> 
				<div id="vidinfotitle"></div>
				<div id="vidinfoview"></div>
				<div id="vidtalk"></div>
				<?php  echo CHtml::image($bUrl.'/file/img/video/vidtalkblock.png','img fuck',array('id'=>'vidtalkimg')); ?>
			</div>
			<div id="vidothers">
				<div><?php echo CHtml::image($bUrl.'/file/img/video/vidoth.png','img fuck',array('id'=>'vidothersimg')); ?></div>
				<div id="vidotherstitle"><?php echo CHtml::image($bUrl.'/file/img/video/others.png','img fuck',array('id'=>'vidotherstitleimg')); ?></div>
				<div id="vidothersout">
					<?php
						echo CHtml::tag('div',array('id'=>'vidothersin'),'',false);
							for($x=0;$x<8;$x++){
								if(($x==5||$x==4)&&(strtotime("now")-strtotime('2013-08-09 00:00:00')<0)){
				
									echo CHtml::tag('div',array('class'=>'divvid'),'',false);

										echo CHtml::tag('div',
											array('class'=>'vidblur',
											'id'=>'vid2'.$x,
											'onclick'=>'comming("vid2")',
											'onmouseover'=>'othervidenter("vid2'.$x.'")',
											'onmouseout'=>'othervidleave("vid2'.$x.'")'),
											'',false);
										echo CHtml::closeTag('div');

										echo Chtml::image($bUrl.'/file/img/video/vid2s.jpg',
											'other vid img fuck',
											array('class'=>'vid')
											);
										echo CHtml::tag('div',array('class'=>'vidothersname'),'',false);
											echo $videoid[$x]['videotitle'];
										echo CHtml::closeTag('div');

									echo CHtml::closeTag('div');
								}
								else if(($x==7||$x==6)&&(strtotime("now")-strtotime('2013-08-12 00:00:00')<0)){
									echo CHtml::tag('div',array('class'=>'divvid'),'',false);

										echo CHtml::tag('div',
											array('class'=>'vidblur',
											'id'=>'vid3'.$x,
											'onclick'=>'comming("vid3b")',
											'onmouseover'=>'othervidenter("vid3'.$x.'")',
											'onmouseout'=>'othervidleave("vid3'.$x.'")'),
											'',false);
										echo CHtml::closeTag('div');

										echo Chtml::image($bUrl.'/file/img/video/vid3s.jpg',
											'other vid img fuck',
											array('class'=>'vid')
											);
										echo CHtml::tag('div',array('class'=>'vidothersname'),'',false);
											echo $videoid[$x]['videotitle'];
										echo CHtml::closeTag('div');

									echo CHtml::closeTag('div');
								}
								else{
									echo CHtml::tag('div',array('class'=>'divvid'),'',false);

										echo CHtml::tag('div',
											array('class'=>'vidblur',
											'id'=>$videoid[$x]['videoid'],
											'onclick'=>'setvid("'.$videoid[$x]['videoid'].'")',
											'onmouseover'=>'othervidenter("'.$videoid[$x]['videoid'].'")',
											'onmouseout'=>'othervidleave("'.$videoid[$x]['videoid'].'")'),
											'',false);
										echo CHtml::closeTag('div');

										echo Chtml::image('http://img.youtube.com/vi/'.$videoid[$x]['videoid'].'/0.jpg',
											'other vid img fuck',
											array('class'=>'vid')
											);
										echo CHtml::tag('div',array('class'=>'vidothersname'),'',false);
											echo $videoid[$x]['videotitle'];
										echo CHtml::closeTag('div');

									echo CHtml::closeTag('div');
								}
							}
						echo CHtml::closeTag('div');
					?>
					<div id="scrollbar"></div>
				</div>

			</div>
		</div>

		<div id="msg" >
			<div id="msgtitle">
				<?php echo CHtml::image( $bUrl.'/file/img/video/msgtitle.png','user image fuck',array('id'=>'msgtitleimg')); ?>
			</div>
			<div id="msgtop">
				<?php 
					if(!(Yii::app()->user->isGuest)){ 
						echo CHtml::tag('div',array('id'=>'msgaddin'),'',false);
				?>
				<?php echo CHtml::image( $bUrl.'/file/img/video/addmsg.png','user image fuck',array('id'=>'msgaddinimg')); ?>
				<div id="msgaddleft">
					<?php echo CHtml::image( Html::getPersonalImgUrl(Yii::app()->user->getId()),'user image fuck',array('id'=>'userimg')); ?>
				</div>

				<div id="msgaddright">
					<div id="msgtaarea">
						<?php echo CHtml::textArea('msg','',array('rows'=>'4','id'=>'msgta','maxlength'=>'40'));?>
					</div>

					<div id="whosay">
						<?php echo CHtml::image($bUrl.'/file/img/video/submit.png','img fuck',array('id'=>'msgsubmit')) ?>
					</div>
				</div>
				<?php 
					echo CHtml::closeTag('div');
				}
					else{
						echo CHtml::tag('div',array('id'=>'msgaddout'),'',false);
						echo CHtml::image($bUrl.'/file/img/video/addmsgout.png','notloginimg fuck',array('id'=>'msgnotloginimg'));
						echo CHtml::closeTag('div');
					}
				?>
			</div>
			<div id="msgline"></div>
			<div id="msgdisplay"  >
				<div id="msgdisplayin"></div>
			</div>
		</div>
	</div>
<?php echo Html::blockBottom('cnt','block'); ?>

					