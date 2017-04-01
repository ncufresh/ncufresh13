<!-- Data-->
<?php
	$mapData = $gameModel->getMapData();
	$mapUsingCard = $gameModel->getMapUsingCard($uid);
	$userProfile = $gameModel->getPlayerDetail($uid);
	$friendData = $gameModel->getFriendDetail($uid);
	$userCard = $gameModel->getOwnedCardList($uid);

	$shopFurniture = $gameModel->getShopFurnitureList();
	$shopCard = $gameModel->getShopCardList();

	$dailyGift = $gameModel->getDailyGift($uid);
	$giftQuery = $giftModel->getGiftQuery($uid);
	$achievement = Yii::app()->params['game']['achievement'];
//$ajaxAction= array("ajaxUsingCard");

	$jsScript = "var ajaxAction = ".CJSON::encode($ajaxAction);
	Yii::app()->clientScript->registerScript('action', $jsScript, CClientScript::POS_HEAD);
	$time = date("Y-m-d G:i:s");
	
?>
<?php
/* @var $this SiteController */
$bUrl=Yii::app()->request->baseUrl;
$this->pageTitle=Yii::app()->name . ' - 小遊戲';

$cs=Yii::app()->clientScript;
$cs->registerScriptFile($bUrl.'/app/js/game/script.js');
	
?>
<script>var mapData = <?=CJSON::encode($mapData);?>;</script>
<script>var mapUsingCard = <?=CJSON::encode($mapUsingCard);?>;</script>
<script>var userProfile = <?=CJSON::encode($userProfile);?>;</script>
<script>var friendData = <?=CJSON::encode($friendData);?>;</script>
<script>var userCard = <?=CJSON::encode($userCard);?>;</script>
<script>var shopFurniture = <?=CJSON::encode($shopFurniture);?>;</script>
<script>var shopCard = <?=CJSON::encode($shopCard);?>;</script>
<script>var s = "<?=$secret;?>";</script>
<script>var daily = "<?=$dailyGift;?>";</script>
<script>var giftQuery = <?=CJSON::encode($giftQuery);?>;</script>
<script>var achievement = <?=CJSON::encode($achievement);?>;</script>
<script>var bUrl = "<?=$bUrl;?>";</script>
<script>var serverTime = "<?=$time;?>";</script>



<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/game.css" />
<div class="cnt_warpped">
	<div class="cnt_head"></div>
	<div class="cnt_body">
		<div id="game_main">
			<div id="game_loading">
				<img id="game_loading_img" src="<?php echo $bUrl?>/file/img/loading.gif" />
			</div>
			<div id="game_message_box">
				<p></p>
			</div>
			<div id="game_get_gift">
				<div id="game_gift_box">
					<div id="game_gift_bar"> 
						<div id="game_gift_items"></div>
					</div>
				</div>
			</div>
			<img src="<?php echo $bUrl?>/file/img/game/map.gif" id="game_map" />
			<img src="<?php echo $bUrl?>/file/img/game/block.gif" id="game_money_img" />
			<div id="game_money">
			</div>
			<img id="game_energy"/>
			<!--<div id="game_chievement">
			</div>-->
			
			<img id="game_cardbar_open" src="<?php echo $bUrl?>/file/img/game/cards.png"/>
			<div id="game_cardbar">
			</div>
			<div id="game_dice_box">
				<img class="game_dice" src="<?php echo $bUrl?>/file/img/game/dice.gif" />
			</div>
			<img src="<?php echo $bUrl?>/file/img/game/Click.png" id="game_setting" />
			<div id="game_setting_bar">
				<img src="<?php echo $bUrl?>/file/img/game/ach.png" id="game_achievement" />
				<img src="<?php echo $bUrl?>/file/img/game/gift.png" id="game_give_gift"/>
				<img src="<?php echo $bUrl?>/file/img/game/rule.png" id="game_rule" />
			</div>
			<div id="game_stepNumber">
			</div>
			<div id="game_friend_box">
				<div id="game_window_divShow">
					<img src="<?php echo $bUrl?>/file/img/game/friend_back.png" id="game_window_img" />
					<img src="<?php echo $bUrl?>/file/img/profile/left.png" id="game_friend_bar_left" />
					<img src="<?php echo $bUrl?>/file/img/profile/right.png" id="game_friend_bar_right" />
					<div id="game_friend_out">
						<div id="game_friend_bar"></div>
					</div>
				</div>
			</div>
			<div id="game_ach_box">
				<img id="game_ach_back" src="<?php echo $bUrl?>/file/img/game/achievement.gif" />
				<div id="game_ach_cnt">
					<div id="game_ach_cnt_bar">
						<div class="game_ach_detail"><pre>遇到機會一次      樂透卡</pre></div>
						<div class="game_ach_detail"><pre>遇到機會五次      骰子卡+加倍卡</pre></div>
						<div class="game_ach_detail"><pre>遇到機會十次      財神卡+衰神卡</pre></div>
						<div class="game_ach_detail"><pre>遇到機會二十五次  能量卡+路障卡+鑽地卡</pre></div>
						<div class="game_ach_detail"><pre>遇到機會五十次    傳送卡+強盜卡+防盜卡</pre></div>
						<div class="game_ach_detail"><pre>遇到機會一百次    免死金牌</pre></div>
						<div class="game_ach_detail"><pre>全部機會成就達成  所有卡片*2</pre></div>
						<div class="game_ach_detail"><pre>遇到命運一次      樂透卡</pre></div>
						<div class="game_ach_detail"><pre>遇到命運五次      骰子卡+加倍卡</pre></div>
						<div class="game_ach_detail"><pre>遇到命運十次      財神卡+衰神卡</pre></div>
						<div class="game_ach_detail"><pre>遇到命運二十五次  能量卡+路障卡+鑽地卡</pre></div>
						<div class="game_ach_detail"><pre>遇到命運五十次    傳送卡+強盜卡+防盜卡</pre></div>
						<div class="game_ach_detail"><pre>遇到命運一百次    免死金牌</pre></div>
						<div class="game_ach_detail"><pre>全部命運成就達成  所有卡片*1</pre></div>
						<div class="game_ach_detail"><pre>答對問答一次      樂透卡</pre></div>
						<div class="game_ach_detail"><pre>答對問答五次      骰子卡+加倍卡</pre></div>
						<div class="game_ach_detail"><pre>答對問答十次      財神卡+衰神卡</pre></div>
						<div class="game_ach_detail"><pre>答對問答二十五次  能量卡+路障卡+鑽地卡</pre></div>
						<div class="game_ach_detail"><pre>答對問答五十次    傳送卡+強盜卡+防盜卡</pre></div>
						<div class="game_ach_detail"><pre>答對問答一百次    免死金牌</pre></div>
						<div class="game_ach_detail"><pre>全部問答成就達成  所有卡片*1</pre></div>
						<div class="game_ach_detail"><pre>總財產超過 250    樂透卡</pre></div>
						<div class="game_ach_detail"><pre>總財產超過 500    骰子卡+加倍卡</pre></div>
						<div class="game_ach_detail"><pre>總財產超過 750    財神卡+衰神卡</pre></div>
						<div class="game_ach_detail"><pre>總財產超過 1000   能量卡+路障卡+鑽地卡</pre></div>
						<div class="game_ach_detail"><pre>總財產超過 1500   傳送卡+強盜卡+防盜卡</pre></div>
						<div class="game_ach_detail"><pre>總財產超過 3000   免死金牌</pre></div>
						<div class="game_ach_detail"><pre>全部財產成就達成  所有卡片*1</pre></div>
						<div class="game_ach_detail"><pre>2項所有成就達成   所有卡片*2</pre></div>
						<div class="game_ach_detail"><pre>3項所有成就達成   所有卡片*3</pre></div>
						<div class="game_ach_detail"><pre>全部項目成就達成  所有卡片*4</pre></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="cnt_btm"></div>
</div>


