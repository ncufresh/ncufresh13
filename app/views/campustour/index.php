<?php
	$bUrl=Yii::app()->request->baseUrl;//the absolute baseUrl
	$cs=Yii::app()->clientScript;
	$cs->registerCSSFile($bUrl.'/css/campusTour.css');//import css file campusTour
	$cs->registerScriptFile($bUrl.'/app/js/campusTour/campusTour.js');//import js file campusTour
	$cs->registerScriptFile('http://maps.googleapis.com/maps/api/js?key=AIzaSyAKbWiSNQZnSSgGKravAphvVhgJivZkFUU&sensor=false');//import js file for googlemap
	$cs->registerScript('campusTourScript', '
 		var motiondetail = '.CJSON::encode($this->createUrl('campusTour/motiondetail')).';
 		var bUrl='.CJSON::encode(Yii::app()->baseUrl).';
		',CClientScript::POS_HEAD);// import js file
?>
<?php echo Html::blockHead('cnt','block'); ?>
		<div id="all">
			<div id="outside">
				<div id="place">
					<div class="place">
						<img id="Dormitory" width="100%"></div>
					<div class="place">
						<img id="Sport" width="100%"></div>
					<div class="place">
						<img id="Landscape" width="100%"></div>
					<div class="place">
						<img id="Meal" width="100%"></div>
					<div id="Meal" class="place">
						<img id="Building" width="100%"></div>
					<div class="place">
						<img id="Department" width="100%"></div>
				</div>

				<div id="map">
					<!-- .mDormitory map item -->
					<img id="basemap" width="98%">
					<img id="G-1-4" class="mDormitory" width="10%" title="女一到四舍">
					<img id="G-5" class="mDormitory"  width="10%" title="女五舍">
					<img id="B-3" class="mDormitory"  width="10%" title="男三舍">
					<img id="B-5" class="mDormitory"  width="10%" title="男五舍">
					<img id="B-6" class="mDormitory"  width="10%" title="男六舍">
					<img id="B-7" class="mDormitory"  width="10%" title="男七舍">
					<img id="B-9" class="mDormitory"  width="10%" title="男九舍">
					<img id="B-11" class="mDormitory"  width="10%" title="男十一舍">
					<img id="B-12" class="mDormitory"  width="10%" title="男十二舍">
					<img id="B-13" class="mDormitory"  width="10%" title="男十三舍">
					<img id="G-14" class="mDormitory"  width="10%" title="女十四舍">
					<img id="B-n" class="mDormitory"  width="10%" title="新研舍">
					<img id="I" class="mDormitory"  width="10%" title="國際學生宿舍">
					<!-- .mSport map item -->
					<img id="Swim" class="mSport"  width="10%" title="游泳池">
					<img id="Playground" class="mSport"  width="10%" title="操場">
					<img id="Gym" class="mSport"  width="10%" title="依仁堂">
					<!-- .mLandscape map item -->
					<img id="Lake" class="mLandscape" title="中大湖">
					<img id="Pool" class="mLandscape" title="烏龜池">
					<img id="Seat" class="mLandscape" title="坐聽‧松風">
					<img id="Cloud" class="mLandscape" title="漫步雲端">
					<img id="Elephant" class="mLandscape" title="大象五行">
					<img id="Wind" class="mLandscape" title="蘊‧行">
					<img id="River" class="mLandscape" title="百花川">
					<img id="Tree" class="mLandscape" title="國泰樹">
					<img id="Pen" class="mLandscape" title="筆墨紙硯">
					<img id="Taichi" class="mLandscape" title="太極銅雕">
					<img id="Grass" class="mLandscape" title="綠草如茵">
					<img id="G-14-ground" class="mLandscape"  width="10%" title="女十四舍廣場">
					<!-- .mMeal map item -->
					<img id="Rest-7" class="mMeal" width="10%" title="男七餐廳">
					<img id="Rest-9" class="mMeal" width="10%" title="男九餐廳">
					<img id="Late" class="mMeal" width="10%" title="宵夜街">
					<img id="Backdoor" class="mMeal" width="10%" title="後門">
					<img id="Cafe" class="mMeal" width="10%" title="校園咖啡">
					<img id="Chalet" class="mMeal" width="15%" title="小木屋鬆餅">
					<img id="Pine" class="mMeal" width="10%" title="松苑廣場">
					<!-- .mBuilding map item -->
					<img id="Admin" class="mBuilding" width="10%" title="行政大樓">
					<img id="Computer" class="mBuilding" width="10%" title="志希館 電算中心">
					<img id="History" class="mBuilding" width="10%" title="校史館">
					<img id="Complex" class="mBuilding" width="10%" title="綜教館">
					<img id="Library" class="mBuilding" width="10%" title="總圖書館">
					<img id="Show" class="mBuilding" width="10%" title="游藝館 據德樓">
					<img id="Guoding" class="mBuilding" width="10%" title="國鼎圖書館">
					<img id="Chungcheng" class="mBuilding" width="10%" title="中正圖書館">
					<img id="Zhidao" class="mBuilding" width="10%" title="志道樓">
					<img id="Hall" class="mBuilding" width="10%" title="中大會館">
					<!-- .mDepartment map item -->
					<img id="Engineering-5" class="mDepartment" width="10%" title="工程五館(資工系館)">
					<img id="Engineering-3" class="mDepartment" width="10%" title="工程三館(機械館)">
					<img id="Engineering-2" class="mDepartment" width="10%" title="工程二館(電機、通訊館)">
					<img id="Engineering-1" class="mDepartment" width="10%" title="工程一館(土木、化材館)">
					<img id="Photoelectric" class="mDepartment" width="10%" title="國鼎光電大樓(光電館)">
					<img id="Science-5" class="mDepartment" width="10%" title="科學五館(生科館)">
					<img id="Science-4" class="mDepartment" width="10%" title="科學四館(物理系)">
					<img id="Science-3" class="mDepartment" width="10%" title="科學三館(化學館)">
					<img id="Science-2" class="mDepartment" width="10%" title="科學二館(大氣館)">
					<img id="Science-1" class="mDepartment" width="10%" title="科學一館(地科館)">
					<img id="Teach" class="mDepartment" width="10%" title="理學院教學館(理學院學士班)">
					<img id="Math" class="mDepartment" width="10%" title="鴻經館(數學館)">
					<img id="Language" class="mDepartment" width="20%" title="文學院(中文、法文、英文)">
					<img id="Manage" class="mDepartment" width="10%" title="管理學院(財經、資管、經濟、企管系館)">
					<img id="Hakka" class="mDepartment" width="10%" title="客家學院大樓">
				</div>
			</div>

			<div id="inside">
				<div id="return" class="inside">
					<img src=<?php echo $bUrl."/file/img/campusTour/arrow.png"; ?> width="90px">
				</div>

				<div id="detail" class="inside">
				</div>
			</div>
		</div>
<?php echo Html::blockBottom('cnt','block'); ?>
