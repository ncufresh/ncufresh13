<?php
	
$bUrl=Yii::app()->request->baseUrl;
$cs=Yii::app()->clientScript;
$cs->registerScriptFile($bUrl.'/app/js/campusLife/campusLife.js');
$cs->registerCssFile($bUrl.'/css/campusLife.css');



for ($i = 1; $i<7; $i++){
	$tmp[$i] = $bUrl. '/file/img/nculife/flip/flip_' . $i . '.png ';
	$temp[$i] = $bUrl. '/file/img/nculife/flip/flip_set_' . $i . '.png ';
}


for ($i = 1; $i<=7; $i++){
	$buttonImg[1][$i] = $bUrl. '/file/img/nculife/button/green_' . $i . '.png ';
	$buttonSet[1][$i] = $bUrl. '/file/img/nculife/button/green_set_' . $i . '.png ';
}

for ($i = 1; $i<=7; $i++){
	$buttonImg[2][$i] = $bUrl. '/file/img/nculife/button/orange_' . $i . '.png ';
	$buttonSet[2][$i] = $bUrl. '/file/img/nculife/button/orange_set_' . $i . '.png ';
}

for ($i = 1; $i<=7; $i++){
	$buttonImg[3][$i] = $bUrl. '/file/img/nculife/button/purple_' . $i . '.png ';
	$buttonSet[3][$i] = $bUrl. '/file/img/nculife/button/purple_set_' . $i . '.png ';
}


for ($i = 1; $i<=3; $i++){
	$buttonImg[4][$i] = $bUrl. '/file/img/nculife/button/blue_' . $i . '.png ';
	$buttonSet[4][$i] = $bUrl. '/file/img/nculife/button/blue_set_' . $i . '.png ';
}

for ($i = 1; $i<=4; $i++){
	$buttonImg[5][$i] = $bUrl. '/file/img/nculife/button/red_' . $i . '.png ';
	$buttonSet[5][$i] = $bUrl. '/file/img/nculife/button/red_set_' . $i . '.png ';
}

for ($i = 1; $i<=3; $i++){
	$buttonImg[6][$i] = $bUrl. '/file/img/nculife/button/yellow_' . $i . '.png ';
	$buttonSet[6][$i] = $bUrl. '/file/img/nculife/button/yellow_set_' . $i . '.png ';
}






$cs->registerScript('campusLifeScript', ' 		
 		var motionBody = '.CJSON::encode($this->createUrl('campusLife/AjaxDynamicView')).';
 		var flip ='.CJSON::encode($tmp).';
 		var flipSet ='.CJSON::encode($temp).';
 		var btnImg ='.CJSON::encode($buttonImg).';
 		var btnSet ='.CJSON::encode($buttonSet).';
 		var bUrl = '.CJSON::encode(Yii::app()->baseUrl).';
		',CClientScript::POS_HEAD);
?>

<?php echo Html::blockHead('cnt','block'); ?>
	<div id="main">
		<div class="flips" id="flipUp">
			<div class="flip" id="flip1">
				<img id = "set1" src=<?php echo $bUrl."/file/img/nculife/flip/flip_1.png" ?>  width="100%">
			</div>
			<div class="flip" id="flip2">
				<img id = "set2" src=<?php echo $bUrl."/file/img/nculife/flip/flip_2.png" ?> width="100%">
			</div>
			<div class="flip" id="flip3">
				<img id = "set3" src=<?php echo $bUrl."/file/img/nculife/flip/flip_3.png" ?> width="100%">
			</div>
		</div>
		
		<div id="mid_slide">
			<div id="mid">
				<div id="button">
				
					<div id="b1" style="display:none;">
						<div class="button" id="_ncuBook">
							<img id="b1_1" src=<?php echo $bUrl."/file/img/nculife/button/green_1.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuGlass">
							<img id="b1_2" src=<?php echo $bUrl."/file/img/nculife/button/green_2.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuHair">
							<img id="b1_3" src=<?php echo $bUrl."/file/img/nculife/button/green_3.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuPrint">
							<img id="b1_4" src=<?php echo $bUrl."/file/img/nculife/button/green_4.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuTheater">
							<img id="b1_5" src=<?php echo $bUrl."/file/img/nculife/button/green_5.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuDrawNow">
							<img id="b1_6" src=<?php echo $bUrl."/file/img/nculife/button/green_6.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuAsus">
							<img id="b1_7" src=<?php echo $bUrl."/file/img/nculife/button/green_7.png" ?> width="100%">
						</div>

					</div>

					<div id="b2" style="display:none;">
						<div class="button" id="_ncuEat">
							<img id="b2_1" src=<?php echo $bUrl."/file/img/nculife/button/orange_1.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuOutDoor">
							<img id="b2_2" src=<?php echo $bUrl."/file/img/nculife/button/orange_2.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuPine">
							<img id="b2_3" src=<?php echo $bUrl."/file/img/nculife/button/orange_3.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuOutEat">
							<img id="b2_4" src=<?php echo $bUrl."/file/img/nculife/button/orange_4.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuLaya">
							<img id="b2_5" src=<?php echo $bUrl."/file/img/nculife/button/orange_5.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuCoffee">
							<img id="b2_6" src=<?php echo $bUrl."/file/img/nculife/button/orange_6.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuFiesta">
							<img id="b2_7" src=<?php echo $bUrl."/file/img/nculife/button/orange_7.png" ?> width="100%">
						</div>
			
					</div>

					<div id="b3" style="display:none;">
						<div class="button" id="_ncuNeed">
							<img id="b3_1" src=<?php echo $bUrl."/file/img/nculife/button/purple_1.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuDormG1_4">
							<img id="b3_2" src=<?php echo $bUrl."/file/img/nculife/button/purple_2.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuDormB3_7">
							<img id="b3_3" src=<?php echo $bUrl."/file/img/nculife/button/purple_3.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuDormB9_11">
							<img id="b3_4" src=<?php echo $bUrl."/file/img/nculife/button/purple_4.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuBank">
							<img id="b3_5" src=<?php echo $bUrl."/file/img/nculife/button/purple_5.png" ?> width="100%">
						</div>

						<div class="button" id="_ncuPost">
							<img id="b3_6" src=<?php echo $bUrl."/file/img/nculife/button/purple_6.png" ?> width="100%">
						</div>

						<div class="button" id="_ncu581">
							<img id="b3_7" src=<?php echo $bUrl."/file/img/nculife/button/purple_7.png" ?> width="100%">
						</div>
					</div>

					<div id="b4" style="display:none;">
						<div class="button" id="_bike">
							<img id="b4_1" src=<?php echo $bUrl."/file/img/nculife/button/blue_1.png" ?> width="100%">
						</div>	

						<div class="button" id="_car">
							<img id="b4_2" src=<?php echo $bUrl."/file/img/nculife/button/blue_2.png" ?> width="100%">
						</div>	

						<div class="button" id="_bus">
							<img id="b4_3" src=<?php echo $bUrl."/file/img/nculife/button/blue_3.png" ?> width="100%">
						</div>	

					</div>

					<div id="b5" style="display:none;">
						<div class="button" id="_outMovie">
							<img id="b5_1" src=<?php echo $bUrl."/file/img/nculife/button/red_1.png" ?> width="100%">
						</div>		

						<div class="button" id="_outKtv">
							<img id="b5_2" src=<?php echo $bUrl."/file/img/nculife/button/red_2.png" ?> width="100%">
						</div>	

						<div class="button" id="_outMarket">
							<img id="b5_3" src=<?php echo $bUrl."/file/img/nculife/button/red_3.png" ?> width="100%">
						</div>
						<div class="button" id="_outStore">
							<img id="b5_4" src=<?php echo $bUrl."/file/img/nculife/button/red_4.png" ?> width="100%">
						</div>						
					</div>

					<div id="b6" style="display:none;">
						<div class="button" id="_ncuHealth">
							<img id="b6_1"src=<?php echo $bUrl."/file/img/nculife/button/yellow_1.png" ?> width="100%">
						</div>		

						<div class="button" id="_ncuStore">
							<img id="b6_2"src=<?php echo $bUrl."/file/img/nculife/button/yellow_2.png" ?> width="100%">
						</div>	

						<div class="button" id="_ncuPsycho">
							<img id="b6_3"src=<?php echo $bUrl."/file/img/nculife/button/yellow_3.png" ?> width="100%">
						</div>			
					</div>
	
				</div>
				<div id="panel" >
					<img src=<?php echo $bUrl."/file/img/nculife/body/body_big.png" ?> width="100%">
					<div id="contentsBar">
						<div id="contents"></div>
					</div>
				</div>
			</div>
		</div>
		
		
			<div class="flips" id="flipDown">
				<div class="flip" id="flip4">
					<img id = "set4" src=<?php echo $bUrl."/file/img/nculife/flip/flip_4.png" ?> width="100%">
				</div>
				
				<div class="flip" id="flip5">
					<img id = "set5" src=<?php echo $bUrl."/file/img/nculife/flip/flip_5.png" ?> width="100%">
				</div>

				<div class="flip" id="flip6">
					<img id = "set6" src=<?php echo $bUrl."/file/img/nculife/flip/flip_6.png" ?> width="100%">
				</div>
			</div>
	</div>

	
<?php echo Html::blockBottom('cnt','block'); ?>



