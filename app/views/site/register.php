<?php 
	$cs=Yii::app()->clientScript;
	$cs->registerCSSFile(Yii::app()->request->baseUrl.'/css/register.css');
?>

<?php echo Html::blockHead("register_background","block"); ?>
	<div class="form">

	<?php 
	$form=$this->beginWidget('CActiveForm', array(
		'id'                     =>'general-register-form',
		'htmlOptions'            =>array('class'=>'form-horizontal'),
		'enableAjaxValidation'   =>false,
		'enableClientValidation' =>true,
		'action'                 =>Yii::app()->createUrl('site/register'),
		 'clientOptions'=>array(
	        'validateOnChange'=>true,
	        'validateOnSubmit'=>true,
	        'afterValidate'	  =>'js:function(form,  data, hasError){
	        		console.log(hasError);
				  	if(hasError){
				  		console.log(\'called\');
				  		$(\'.control-group input\').popover(\'show\');
				  		return false;
				  	}else{
				  		return true;
				  	}
				  }
	        ',
	        'hideErrorMessage'=>true,
	    ),
	)); ?>

	
	<div id="register_warpped">
		<div id="register_head">
			<div style="color: white; left: 64%; position: absolute; top: 39%;">請仔細填資料!註冊後無法修改喔>.^</div>
			<?php echo $form->errorSummary($formModel,"請修正以下問題",NULL,array("style"=>"color: red; left: 60%; position: absolute; top: 68%;")); ?>
		</div>
		<div id="register_body">
			<div class="column">
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'name',array('class'=>"control-label")); ?>
					<?php echo $form->textField($formModel,'name',array('tips'=>'請輸入您的真實姓名','class'=>'input','size'=>30,'maxlength'=>10)); ?>
					<?php echo $form->error($formModel,'name'); ?>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'nickname',array('class'=>"control-label")); ?>
					<?php echo $form->textField($formModel,'nickname',array('tips'=>'請輸入您的暱稱，最多不超過10個字元','size'=>30,'maxlength'=>10)); ?>
					<?php echo $form->error($formModel,'nickname'); ?>
				</div>
				
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'sex',array('class'=>"control-label")); ?>
				<!--<div class="btn-group" data-toggle="buttons-radio">
					  <button type="button" class="btn btn-primary">Boy</button>
					  <button type="button" class="btn btn-primary">Girl</button>
					</div> -->
					<?php echo $form->radioButtonList($formModel,'sex',array('m'=>'男生','f'=>'女生'),array('labelOptions'=>array('style'=>'display:inline'),'separator' => " " )); ?>
					<?php echo $form->error($formModel,'sex'); ?>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'birthday',array('class'=>"control-label")); ?>
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
					    'model'=>$formModel, 'attribute'=>'birthday',
					    'options'=>array(
							 'showAnim'=>'fold',
							 'dateFormat'=>'yy-mm-dd',
							 'changeMonth'=>true,
							 'changeYear'=>true,
							 'yearRange'=>'1985:1997',
							 'defaultDate'=>'1994-01-01'
					    ),
					    'htmlOptions'=>array(
					    	'readonly'=>'true',
					    	'onFocus'=>'this.blur()',
					    ),
					)); ?>
					<?php echo $form->error($formModel,'birthday'); ?>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'high_school',array('class'=>"control-label")); ?>
					<?php echo $form->textField($formModel,'high_school',array('tips'=>'請輸入您的畢業高中','autocomplete'=>'off','data-provide'=>'typeahead','size'=>30,'maxlength'=>30)); ?>
					<?php echo $form->error($formModel,'high_school'); ?>
				</div>	
				<div class="control-group" >
					<?php echo $form->labelEx($formModel,'department_id',array('class'=>"control-label")); ?>
					<?php echo $form->dropDownList($formModel,'department_id',CHtml::listData($formModel->departmentIdArray(),'department_id','department_name')); ?>
					<?php echo $form->error($formModel,'department_id'); ?>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'grade',array('class'=>"control-label")); ?>
					<?php echo $form->dropDownList($formModel,'grade',array('一'=>'一年級','二'=>'二年級','三'=>'三年級','四'=>'四年級')); ?>
					<?php echo $form->error($formModel,'grade'); ?>
				</div>


			</div>
			<div class="column">
				<div class="control-group">
					<?php echo $form->labelEx($formModel,'username',array('class'=>"control-label")); ?>
					<?php echo $form->textField($formModel,'username',array('tips'=>'帳號需為e-mail〈例：ncu@gmail.com〉，最少不可低於N字元','size'=>30,'maxlength'=>30)); ?>
					<?php echo $form->error($formModel,'username'); ?>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($formModel,'password',array('class'=>"control-label")); ?>
					<?php echo $form->passwordField($formModel,'password',array('tips'=>'密碼建議設為N字元以上，且為英文數字混合','size'=>30,'maxlength'=>30)); ?>
					<?php echo $form->error($formModel,'password'); ?>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($formModel,'repassword',array('class'=>"control-label")); ?>
					<?php echo $form->passwordField($formModel,'repassword',array('tips'=>'請再次輸入密碼以確認為正確','size'=>30,'maxlength'=>30)); ?>
					<?php echo $form->error($formModel,'repassword'); ?>
				</div>

				<div class="button" id="reset"></div>
				<div class="control-group" id="check">
					<div class="row buttons">
							<?php echo CHtml::imageButton(Yii::app()->baseUrl.'/file/img/register/registerButton.gif',array("style"=>"width:100px;height:71px;float:right;margin-right:60px;"));?>
							<a href="#"  onClick="$('#general-register-form')[0].reset();return false;" style="width:100px;height:71px;display:block;float:right;">
								<img src="<?php echo Yii::app()->baseUrl.'/file/img/register/clearButton.gif'; ?>" style="width:100px">
							</a>
					</div>

				</div>
			</div>
		</div>
		<div id="register_btm"></div>
	</div>

		

	<?php $this->endWidget(); ?>

	</div><!-- form -->


		<!-- test -->

<script type="text/javascript">

   $('.control-group input').tooltip({
		trigger  : 'hover',
		html     : false,
		animation: true,
		placement: 'right',
		title    : function() {
		return $(this).attr('tips');
		}
  });

   	$(".errorMessage").bind("DOMSubtreeModified",function(){
   	  	var msg=$(this).text();
   	  	if(msg==''){
   	  		console.dir($(this).closest('input'));
   	  		$(this).parent().children("input").popover('destroy');
		}else{
			$(this).parent().children("input").popover('destroy').popover({
				trigger  : 'manual',
				html     : true,
				animation: true,
				placement: 'left',
				content  : msg
		  	}).popover('show');
		}
	});

	var _addClass    = $.fn.addClass;
	$.fn.addClass    = function(){
		var result=_addClass.apply(this, arguments)
		if(arguments[0]=='error'||arguments[0]=='success'){
			$('.success .errorMessage').empty();
		}
	    return result;
	}



	var subjects = ['國立華僑中學','私立淡江高中','私立康橋高中','私立金陵女中','財團法人南山高中','財團法人恆毅高中','私立聖心女中','私立崇義高中','財團法人中華高中','私立東海高中','私立格致高中','私立醒吾高中','私立徐匯高中','財團法人崇光女中','私立光仁高中','私立竹林高中','私立及人高中','財團法人辭修高中','私立時雨高中','市立泰山高中','市立板橋高中','市立新店高中','市立中和高中','市立新莊高中','市立新北高中','市立林口高中','市立海山高中','市立三重高中','市立永平高中','市立樹林高中','市立明德高中','市立秀峰高中','市立金山高中','市立安康高中','市立雙溪高中','市立石碇高中','市立丹鳳高中','市立清水高中','市立三民高中','市立錦和高中','市立光復高中','市立竹圍高中','市立西松高中','市立中崙高中','私立祐德中學','市立松山高中','市立永春高中','國立師大附中','私立延平中學','私立金甌女中','私立復興實驗高中','市立和平高中','私立中興中學','私立大同高中','市立中山女中','市立大同高中','市立大直高中','私立強恕中學','市立建國中學','市立成功中學','市立北一女中','私立靜修女中','市立明倫高中','市立成淵高中','私立立人高中','市立華江高中','市立大理高中','國立政大附中','私立東山高中','私立滬江高中','私立大誠高中','私立再興中學','私立景文高中','市立景美女中','市立萬芳高中','市立南港高中','市立育成高中','私立文德女中','私立方濟中學','私立達人女中','市立內湖高中','市立麗山高中','市立南湖高中','私立泰北高中','私立衛理女中','私立華興中學','市立陽明高中','市立百齡高中','私立薇閣高中','私立十信高中','市立復興高中','市立中正高中','國立大甲高中','國立清水高中','國立豐原高中','國立大里高中','國立中科實驗高級中學','財團法人常春藤高中','私立明台高中','私立致用高中','私立大明高中','私立嘉陽高中','私立明道高中','私立僑泰高中','私立華盛頓高中','私立青年高中','私立弘文高中','私立立人高中','私立玉山高中','私立慈明高中','市立后綜高中','市立大里高中','市立新社高中','市立長億高中','市立中港高中','國立台中女中','國立台中一中','國立台中二中','國立文華高中','私立東大附中','私立葳格高中','私立新民高中','私立宜寧高中','私立明德女中','私立衛道高中','私立曉明女中','私立嶺東高中','市立忠明高中','市立西苑高中','市立東山高中','市立惠文高中','國立新豐高中','國立臺南大學附中','國立北門高中','國立新營高中','國立後壁高中','國立善化高中','國立新化高中','國立南科國際實驗高中','私立南光高中','私立鳳和高中','私立港明高中','私立興國高中','私立明達高中','私立黎明高中','私立華濟永安高中','私立新榮高中','市立大灣高中','市立永仁高中','國立臺南二中','國立臺南一中','國立臺南女中','國立家齊女中','私立長榮高中','私立長榮女中','財團法人聖功女中','私立光華女中','私立六信高中','私立瀛海高中','私立崑山高中','私立德光高中','財團法人慈濟高中','市立南寧高中','市立土城高中','國立鳳山高中','國立岡山高中','國立旗美高中','國立鳳新高中','財團法人新光高中','財團法人普門中學','私立正義高中','私立義大國際高中','市立文山高中','市立林園高中','市立仁武高中','市立路竹高中','市立六龜高中','市立福誠高中','私立明誠高中','私立大榮高中','市立鼓山高中','市立左營高中','市立新莊高中','國立中山大學附屬國光高中','市立中山高中','市立楠梓高中','私立立志高中','市立高雄中學','市立三民高中','市立新興高中','市立高雄女中','國立高師大附中','私立復華高中','天主教道明中學','市立中正高中','市立前鎮高中','市立瑞祥高中','市立小港高中','國立蘭陽女中','國立宜蘭高中','國立羅東高中','私立慧燈高中','私立中道高中','縣立南澳高中','國立桃園高中','國立中央大學附屬中壢高中','國立武陵高中','國立楊梅高中','國立陽明高中','國立內壢高中','私立泉僑高中','私立育達高中','私立六和高中','私立復旦高中','私立治平高中','私立振聲高中','私立光啟高中','私立啟英高中','私立清華高中','私立新興高中','私立至善高中','私立大興高中','私立大華高中','縣立南崁高中','縣立大溪高中','縣立壽山高中','縣立平鎮高中','縣立觀音高中','縣立永豐高中','縣立大園國際高中','國立竹東高中','國立關西高中','國立竹北高中','私立義民高中','私立忠信高中','私立東泰高中','私立仰德高中','縣立湖口高中','國立苗栗高中','國立竹南高中','國立卓蘭實驗高中','國立苑裡高中','私立君毅高中','私立大成高中','私立建臺高中','私立全人實驗高中','縣立三義高中','縣立苑裡高中','縣立興華高中','縣立大同高中','國立彰化女中','國立員林高中','國立彰化高中','國立鹿港高中','國立溪湖高中','私立精誠高中','私立文興高中','財團法人正德高中','縣立彰化藝術高中','縣立二林高中','縣立和美高中','縣立田中高中','縣立成功高中','國立南投高中','國立中興高中','國立竹山高中','國立暨大附中','私立五育高中','私立三育高中','私立弘明實驗高中','私立普台高中','縣立旭光高中','國立斗六高中','國立北港高中','國立虎尾高中','私立永年高中','私立正心高中','私立文生高中','私立巨人高中','私立揚子高中','財團法人義峰高中','私立福智高中','雲林縣維多利亞實驗高中','縣立斗南高中','縣立麥寮高中','國立東石高中','國立新港藝術高中','私立同濟高中','私立協同高中','縣立竹崎高中','縣立永慶高中','國立屏東女中','國立屏東高中','國立潮州高中','國立屏北高中','財團法人屏榮高中','私立陸興高中','私立美和高中','私立新基中學','縣立大同高中','縣立枋寮高中','縣立東港高中','縣立來義高中','國立臺東大學附屬體育高中','國立臺東女中','國立臺東高中','私立育仁高中','縣立蘭嶼高中','國立花蓮女中','國立花蓮高中','國立玉里高中','私立海星高中','私立四維高中','財團法人慈濟大學附中','花蓮縣立體育實驗高中','縣立南平中學','國立馬公高中','國立基隆女中','國立基隆高中','私立二信高中','私立聖心高中','市立中山高中','市立安樂高中','市立暖暖高中','市立八斗高中','國立科學工業園區實驗高中','國立新竹女中','國立新竹高中','私立光復高中','私立曙光女中','私立磐石高中','私立世界高中','市立成德高中','市立香山高中','市立建功高中','國立嘉義女中','國立嘉義高中','私立興華高中','私立仁義高中','私立嘉華高中','私立輔仁高中','私立宏仁女中','私立立仁高中','國立金門高中','國立馬祖高中','私立樹人家商','私立復興商工','私立南強工商','私立穀保家商','私立開明工商','私立智光商工','私立清傳高商','私立能仁家商','私立豫章工商','私立莊敬工家','私立中華商海','市立瑞芳高工','市立三重商工','市立新北高工','市立淡水商工','市立鶯歌工商','私立育達家商','私立協和工商','市立松山家商','市立松山工農','私立東方工商','私立喬治工商','私立開平餐飲','市立大安高工','私立稻江護家','私立開南商工','私立稻江高商','市立木柵高工','市立南港高工','市立內湖高工','私立華岡藝校','市立士林高商','私立惇敘工商','國立豐原高商','國立大甲高工','國立東勢高工','國立沙鹿高工','國立霧峰農工','國立台中家商','國立台中高農','國立台中高工','財團法人光華高工','國立新化高工','國立白河商工','國立北門農工','國立曾文家商','國立新營高工','國立玉井工商','國立臺南高工','國立曾文農工','私立天仁工商','私立陽明工商','私立育德工家','國立臺南高商','國立臺南海事','私立南英商工','私立亞洲餐旅','私立慈幼工商','國立旗山農工','國立岡山農工','國立鳳山商工','私立中山工商','私立旗美商工','私立高英工商','私立華德工家','私立高苑工商','私立中華藝校','市立海青工商','市立三民家商','私立樹德家商','市立高雄高工','市立高雄高商','私立國際商工','私立三信家商','市立中正高工','私立高鳳工家','國立宜蘭高商','國立羅東高商','國立蘇澳海事','國立羅東高工','國立頭城家商','國立龍潭農工','國立桃園農工','國立中壢高商','國立中壢家商','私立成功工商','私立方曙商工','私立永平工商','私立內思高工','國立大湖農工','國立苗栗農工','國立苗栗高商','私立中興商工','私立育民工家','私立賢德工商','私立龍德家商','國立彰師附工','國立永靖高工','國立二林工商','國立秀水高工','國立彰化高商','國立員林農工','國立員林崇實高工','國立員林家商','國立北斗家商','私立大慶商工','私立達德商工','國立仁愛高農','國立埔里高工','國立南投高商','國立草屯商工','國立水里商工','私立同德家商','國立虎尾農工','國立西螺農工','國立斗六家商','國立北港農工','國立土庫商工','私立大成商工','私立大德工商','國立民雄農工','私立協志工商','私立萬能工商','私立弘德工商','國立內埔農工','國立屏東高工','國立佳冬高農','國立東港海事','國立恆春工商','私立民生家商','私立華洲工家','私立日新工商','國立關山工商','國立臺東高商','國立成功商水','私立公東高工','國立花蓮高農','國立花蓮高工','國立花蓮高商','國立光復商工','私立中華工商','國立澎湖海事水產','國立基隆海事','國立基隆商工','私立光隆家商','私立培德工家','國立新竹高商','國立新竹高工','國立華南高商','國立嘉義高工','國立嘉義高商','國立嘉義家職','私立東吳工家','私立大同高商','國立金門農工'];
	$('#GeneralUserProfile_high_school').typeahead({
		source: subjects,
		items:  5,

	});
</script>
	<!-- testend -->
<?php echo Html::blockBottom("register","block"); ?>

