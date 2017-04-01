<!-- Data-->
<?php


$model=new CalendarForm ;
$criteria=new CDbCriteria;
$criteria->select='*';
$model=CalendarForm::model()->findAll($criteria); // $params is not needed

$array=array() ;
foreach ($model as $thisData) {
	array_push($array, $thisData) ;//繚|禮璽$thisData穠繙繡礙簞T穢簽穡穫$array瞻瞻(瞼H簞}礎C禮�礎癒)
}
$rangeModel = new CalendarForm ;
$length = $rangeModel -> getLength() ;

//use it in id=eventDisplay 從model取值
for(  $a=0 ; $a<count($array) ; $a++  ){
	$firstday[$a]=$array[$a]['firstday'] ;
	$finalday[$a]=$array[$a]['finalday'] ;
	$event[$a]=$array[$a]['event'] ;//use it in id=index_hot_body
	$first_day[$a]=$array[$a]['first_day'] ;//use it in id=index_hot_body
	$final_day[$a]=$array[$a]['final_day'] ;//use it in id=index_hot_body
	$id[$a]=$array[$a]['id'] ;//use it in id=index_hot_body
}
$widthModel = new CalendarForm ;
list($width, $leftlength, $rightlength, $hint) = $widthModel -> getAllMessage( $firstday, $finalday ) ;

//use it in id=index_hot_body
list($todayEvent, $eventNumber, $ID) = $widthModel -> getResentEvent( $first_day, $final_day, $event ) ;

if(count($todayEvent) == 0){
	$todayEvent = array('沒有活動');
}


$furnitureData = $homeModel->getOwnedFurnitureList($visitUid, true);
$skinData = $skinModel->getOwnedSkinList($visitUid);
$userProfile = $userModel->getPublicUserProfile($visitUid);

$skinShopData = $skinModel->getShopSkinList();
$furnitureShopData = $homeModel->getShopFurnitureList();

$uidPeople = Yii::app()->user->getId();

$jsScript = "var ajaxAction = ".CJSON::encode($ajaxAction);
Yii::app()->clientScript->registerScript('action', $jsScript, CClientScript::POS_HEAD);
?>
<script>var s = "<?=$secret;?>";</script>
<script>var isFriend = "<?=$isFriend;?>";</script>
<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - 個人小屋';

$cs=Yii::app()->clientScript;
$bUrl=Yii::app()->request->baseUrl;//the absolute baseUrl
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/app/js/profile/script.js');
$cs->registerCSSFile($bUrl.'/css/profile.css');//import css file campusTour



?>



<script>var login = "<?=$login;?>";</script>
<script>var itself = "<?=$itself;?>";</script>

<script>var furnitureData = <?=CJSON::encode($furnitureData);?>;</script>
<script>var skinData = <?=CJSON::encode($skinData);?>;</script>
<script>var userProfile = <?=CJSON::encode($userProfile);?>;</script>

<script>var skinShopData = <?=CJSON::encode($skinShopData);?>;</script>
<script>var furnitureShopData = <?=CJSON::encode($furnitureShopData);?>;</script>
<script>var uidPeople = "<?=$uidPeople;?>";</script>
<script>var todayEvent = <?=CJSON::encode($todayEvent);?>;</script>

<?php
	if($itself == 1){
		$friendModel = new FriendModel;
		$friendList = $friendModel->getFriendList($visitUid);
		$suggestList = $friendModel->getSuggestFriendList($visitUid);
		?>
		<script>var friendList = <?=CJSON::encode($friendList);?>;</script>
		<script>var suggestList = <?=CJSON::encode($suggestList);?>;</script>
<?php
	}

?>


<div class="cnt_warpped" id="profile_sub">
	<div class="close">
		<img id="profile_sub_close" src="<?=$bUrl?>/file/img/close.png" style="opacity: 1;">
	</div>
	<div class="cnt_head"></div>
	<div class="cnt_body">
		<div id="profile_sub_cnt">
			
		</div>
	</div>
	<div class="cnt_btm"></div>
</div>
<div class="cnt_warpped">
	<div class="cnt_head"></div>
	<div class="cnt_body">
		<div id="profile_main">
			<div id="furmiture">
				<img src="<?php echo $bUrl ?>/file/img/profile/house.png" id="profile_house" class="profile_image"/>
				<?php

					$furnitureUrl = $bUrl."/file/img/profile/furniture/";
					foreach($furnitureData as $thisData){
						echo CHtml::tag('img', array(
								'src' => $furnitureUrl.$thisData['fid'].'.gif',
								'class' => 'profile_image hi_furniture'
							), NULL, false
						);
					}
				?>

				<img src="<?php echo $bUrl ?>/file/img/profile/doorplate.gif" id="profile_doorplate" class="profile_image"/>
			</div>
			<img src="<?php echo $bUrl ?>/file/img/profile/messageBoard_cut.gif" id="profile_messageBoard" class="profile_image"/>
			<img src="<?php echo $bUrl ?>/file/img/profile/calendar_cut.png" id="profile_calendar" class="profile_image profile_calender_all"/>
			<img src="<?php echo $bUrl ?>/file/img/profile/dice_cut.gif" id="profile_dice" class="profile_image"/>
			<img src="<?php echo $bUrl ?>/file/img/profile/cloth_cut.gif" id="profile_cloth" class="profile_image"/>
			<img src="<?php echo $bUrl ?>/file/img/personal/<?php echo $userProfile['skin_id'];?>.gif" id="profile_person" class="profile_image"/>

			<style>
				.calender_day{
					width:51px;
					height:75px;
				}
			</style>

			<?php
				//Calender
				$calenderURL = $bUrl."/file/img/profile/calender/";
				$today = date('d');
				echo CHtml::tag('img', array(
					'src' => $calenderURL.substr($today, 0, 1).'.png',
					'class' => 'calender_day_left calender_day profile_calender_all',
					'style' => 'left:260px;
								top:51px;
								position:absolute;
								',
					), NULL, false);

				echo CHtml::tag('img', array(
					'src' => $calenderURL.substr($today, 1, 2).'.png',
					'class' => 'calender_day_right calender_day profile_calender_all',
					'style' => 'left:307px;
								top:51px;
								position:absolute;
								'
				), NULL, false);

				//month
				$month = date('M');
				echo CHtml::tag('img', array(
					'src' => $calenderURL.$month.'.png',
					'class' => 'calender_month profile_calender_all',
					'style' => 'left:278px;
								top:28px;
								height:26px;
								position:absolute;
								'
				), NULL, false);

				// name
				echo CHtml::tag('div', array(
					'style' => 'position: absolute;
								left: 902px;
								top: 382px;
								color: lime;
								',
					'class' => 'profile_doorplate_name',
				), $userProfile['nickname'], true);
			?>
		<div id="profile_calendar_all"></div>
		</div>
	</div>
	<div class="cnt_btm"></div>
</div>
