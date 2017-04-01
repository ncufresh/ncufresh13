<!DOCTYPE HTML>
<html lang="zh">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="「2013 大一生活知訊網」提供中大新鮮人所需要的訊息，包括註冊、選課、宿舍、科系、社團等各方面實用的資訊，還有其它的生活小密技，讓新生提早了解校園生活的各種面貌。" />
    <meta name="keywords" content="國立中央大學, 中央大學, 中大, 央大, 大一生活知訊網, 生活知訊網, 知訊網, NCU, NCUFreshWeb, NCUFresh, 2013" />
    <meta name="author" content="National Central University FreshWeb Team." />
    <meta name="revised" content="<?php echo date('Y/m/d'); ?>" />

	<meta name="language" content="zh" />
	<link href="<?php echo Yii::app()->baseUrl;?>/file/img/favicon.ico" rel="icon" type="image/x-icon" />
	<script>
		var bUrl="<?php echo Yii::app()->baseUrl;?>";
		var csrf_token = "<?php echo Yii::app()->request->csrfToken?>";
	</script>

	<?php
		Yii::app()->counter->refresh();
		if(preg_match('/(?i)msie [2-8]/',$_SERVER['HTTP_USER_AGENT'])){
			echo '<script>
						alert("你目前所使用的瀏覽器已經落伍了\\n為了獲得更佳的瀏覽品質\\n建議您更換其他瀏覽器。");
					</script>';
		}
	?>

	<!-- blueprint CSS framework -->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>
	<div id="back"></div>
	<div class="alert">
	  <strong></strong>
	  <p></p>
	</div>
	<div id="bodyscroll">
		<div id="bodywrapped">
			<div id="opacity_pane"></div>
			<div id="orgingebar">
				<div style="left: 27%; position: absolute;">人氣指數:<?php echo Yii::app()->counter->getTotal(); ?> 今日人數:<?php echo Yii::app()->counter->getToday(); ?></div>
			</div>
			<div class="container" id="page">
				<div id="header">
					
					<div id="head_warpped">
						<div class="head" id="head_left">
							<div id="logo">
								<?php
									$bUrl=Yii::app()->request->baseUrl;
									$imgPath=$bUrl.'/file'.'/'.'img'.'/'.'logo.gif';

									$imgtag=CHtml::tag('img',array(
											'src' =>$imgPath,
											'style' => 'border-style:none;'
										),'',false);
									$link=CHtml::tag('a',array(
											'href'=> Yii::app()->createUrl('site/index')
										),$imgtag,true);
									echo $link;
								?>	
							</div>
						</div>
						<div class="head" id="head_right_block"></div>
						<div class="head" id="head_right_block"></div>
						<div class="head" id="head_right">
							<div class="head" id="head_right_up">
								<div class="head headbutton" id="head_right_up_left_up">
									<?php echo Html::headImgButton('campusLife',Yii::app()->controller->id,array('活在中大','食在中大','住在中大','行車中大','中大校外','健康中大')) ?>
									<?php echo Html::headImgButton('majorClub',Yii::app()->controller->id,array('工學院','理學院','資電學院','管理學院','文學院','客家學院','校隊','學生自治','聯誼性社團','服務性社團','康樂性社團','學術性社團')) ?>
								</div>
								<div class="head headbutton" id="head_right_up_left_down">
									<?php  $articleArray = Article::model()->getHottestArticle() ;
											$titleArray=array();
											foreach ($articleArray as $value) {
												array_push($titleArray, CHtml::encode($value['title']));
											}
									?> 
									<?php echo Html::headImgButton('forum',Yii::app()->controller->id,$titleArray) ?>
									<?php echo Html::headImgButton('campusTour',Yii::app()->controller->id,array('宿舍介紹','運動介紹','景點介紹','餐廳介紹','建築介紹','系所介紹')) ?>
								</div>
								<div id="head_login"><?php  $this->widget('application.components.LoginWidget');?></div>
							</div>
							<div class="head headbutton" id="head_right_down">
								<?php echo Html::headImgButton('freshmanread',Yii::app()->controller->id,array('新生及復學須知','文件下載','輔導及活動','生活相關須知')) ?>
								<?php echo Html::headImgButton('video',Yii::app()->controller->id,array('食在好去處','無法逃避的事實','中藝大集合','慶哥不要','穿越大富翁part1','穿越大富翁part2','春。廢宅。陽光part1','春。廢宅。陽光part2')) ?>
								<?php echo Html::headImgButton('about',Yii::app()->controller->id,array('執行組','企劃組','程設組','美工組','影音組','花絮')) ?>
							</div>
						</div>
					</div>
				</div>
				<!-- header -->
				<div class="clear"></div>
				<div class="container" id="content">
					<?php echo $content; ?></div>
				<div class="clear"></div>

				<div id="footer" >
					<div id="footer-content">
			            <p>
			                主辦單位：國立中央大學學務處　承辦單位：<a href="http://love.adm.ncu.edu.tw" title="國立中央大學 諮商中心">諮商中心</a>　執行單位：2013大一生活知訊網工作團隊
			            </p>
			            <p>
			                地址：32001桃園縣中壢市五權里2鄰中大路300號 | 電話：(03)422-7151#57261 | 版權所有：<a href="mailto:cxx4c7tn@hotmail.com">2013大一生活知訊網工作團隊</a>
			            </p>
			        </div>
				</div>
				<!-- footer -->

			</div>
			<!-- page -->
			
		</div>
	</div>
	
</body>
