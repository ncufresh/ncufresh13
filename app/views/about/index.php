<!-- Data-->
<?php
	/* @var $this SiteController */
	$bUrl=Yii::app()->request->baseUrl;//the absolute baseUrl
	$cs=Yii::app()->clientScript;
	$cs->registerCSSFile($bUrl.'/css/about.css');// import css file about.css
	$cs->registerScriptFile($bUrl.'/app/js/about/script.js');//import js file script.js
	$cs->registerScript('script', '
		var dialog = '.CJSON::encode($this->createUrl('about/dialog')).';
	 	var bUrl='.CJSON::encode(Yii::app()->baseUrl).';
		',CClientScript::POS_HEAD);// import js file
?>
<div class="cnt_warpped">
	<div class="cnt_head"></div>
	<div class="cnt_body">
		<div id="space">
			<img id="mask" width="100%">
			<div id="dialog">
				<div id="frame">
					<div id="introduction">
						<p>嗨！各位大一新生你們好！經過了許久的等待，終於就快接近大學多采多姿的生活了。
						相信你們對於中央大學一定抱持著很多期待，不論是嚮往還是害怕都沒有關係，因為走過同樣的路所以了解你們的擔心與緊張。
						也正是因為如此，我們2013年大一生活知訊網的團隊準備了豐盛的網路饗宴讓你們一起了解中央大學，也一起了解大學的生活。<br />
						<br />
						一年接著一年的傳承，大一生活知訊網的團隊也經過了幾個年頭的傳承。
						而支撐起整個團隊的能量來源就是當所有大一新生都能開心的迎接新的生活。
						為此我們也設法讓網站更加創新，讓大家能夠事先調適進入大學的心態，甚至提早認識新的同學。<br />
						<br />
						我們蒐集了許許多多的資料，就是為了讓各位大一新生更能了解中央大學。
						所以我們在<a href=<?php echo $bUrl."/campusLife/index.html"?>>中大生活</a>裡，分享了許多生活在中央一定會遇到的大小需求解答。
						在<a href=<?php echo $bUrl."/forum/index.html"?>>新生論壇</a>裡，提供了一個讓大家可以詢求答案的平台，不論是各種問題學長姐們也都會很樂意為你們解答。
						在<a href=<?php echo $bUrl."/freshmanread/index.html"?>>大一必讀</a>裡，匯集了各位大一新生必須知道的程序及細節，不論註冊、兵役問題或是選課疑問等，這裡都會有許多詳細的資料供你們參考。
						在<a href=<?php echo $bUrl."/majorClub/index.html"?>>系所社團</a>裡，舉凡中央大學的社團、系所的資訊，我們蒐集了相關的資訊讓大一們的已事先了解未來的系所或是嚮往的社團。
						在<a href=<?php echo $bUrl."/campusTour/index.html"?>>校園導覽</a>裡，彙整了所有在校園內的大小景觀建築，並且提供相關的資訊及說明。
						在<a href=<?php echo $bUrl."/video/index.html"?>>影音專區</a>裡，輯錄了知訊網團隊親自拍攝製作的短片，每一部都包含了大學生活的一部分，絕對值得大家欣賞玩味。<br />
						<br />
						在此，非常感謝你們使用大一生活知訊網。
						在十月我們將完成團隊的使命－「帶領各位熟悉中大校園」。
						在十月之後，我們團隊將會傳承給下一代的你們，讓知訊網能夠薪火相傳。
						如果你有感受到知訊網的用心，願意為下一屆的學弟妹們盡一份心力，並且對知訊網有很多想法及熱情，歡迎你們加入，「２０１４大一生活知訊網」
						詳細在開學後的十月、十一月，將會在校園各處或是ＢＢＳ上張貼訊息、公布招募資訊，屆時將有更完整的資訊，請大家敬請期待！</p><br />
						<br />
						<img src=<?php echo $bUrl."/file/img/about/photo/total.jpg"?> width="100%">
					</div>
				</div>
			</div>
			<div id="mdadmin" class="match">
			</div>
			<div id="mdprogram" class="match">
			</div>
			<div id="mddesign" class="match">
			</div>
			<div id="mdmedia" class="match">
			</div>
			<div id="mdproject" class="match">
			</div>
			<div id="mdphoto" class="match">
			</div>
			<div id="dadmin" class="shape">
				<img id="admin" class="drag" width="100%">
			</div>
			<div id="dprogram" class="shape">
				<img id="program" class="drag" width="100%">
			</div>
			<div id="ddesign" class="shape">
				<img id="design" class="drag" width="100%">
			</div>
			<div id="dmedia" class="shape">
				<img id="media" class="drag" width="100%">
			</div>
			<div id="dproject" class="shape">
				<img id="project" class="drag" width="100%">
			</div>
			<div id="dphoto" class="shape">
				<img id="photo" class="drag" width="100%">
			</div>
			<div id="ddeload" class="shape">
				<img id="deload" class="drag" width="100%">
			</div>
		</div>
	</div>
	<div class="cnt_btm"></div>
</div>


