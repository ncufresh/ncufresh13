<?php $cs=Yii::app()->clientScript;
      $bUrl=Yii::app()->request->baseUrl;
?>
<div style="position:absolute" >
	<img id="freshButtom" src="<?php echo $bUrl?>/file/img/freshmanread/freshFlag.gif" style="opacity:1 ;"  >
</div>

<div style="position:absolute" >
	<img id="enrollButtom" src="<?php echo $bUrl?>/file/img/freshmanread/backFlag.gif" style="opacity:0.3;" >
</div>

<div id="FreshmanView">
	<ul id="fre_leftcolumn" class="leftcolumn" >
		<li id="fre_1">大一新生ucan職業興趣測驗</li>
		<li id="fre_2" >大一新生心理調適講座</li>
		<li id="fre_3">健康檢查</li>
		<li id="fre_4">大一新生國文寫作測驗</li>
		<li id="fre_5">僑生與中文系外籍生大一中文能力分級測驗</li>
		<li id="fre_6">註冊日程及程序</li>
	</ul>
	
	<ul id="fre_rightcolumn" class="rightcolumn" >
		<li id="fre_7">線上登錄學生學籍資料</li>
		<li id="fre_8">學雜費及相關減免</li>
		<li id="fre_9">大一國文須知</li>
		<li id="fre_10">大一英文修課規定</li>
		<li id="fre_11">學生學習協助與輔導</li>
		<li id="fre_12">服務學習</li>
		<li id="fre_13">選課系統</li>
	</ul>

	

	<img id="freshNotify" src="<?php echo $bUrl?>/file/img/freshmanread/freshNotify.gif" style="margin-left:265px; display:none ;position:absolute ;margin-top:155px ;" >

	<div id="people1div" style="position:absolute ; margin-left:445px ; margin-top:25px ; ">
		<img id="people1" src="<?php echo $bUrl?>/file/img/freshmanread/Manfresh.gif" style="position:absolute ; margin-left:290px ; margin-top:246px ; height:170px" >
	</div>



</div>

  <script type="text/javascript">
  
 //  	$("#nav_freshman").css("background-color","#FFCB7D") ;
 //  	$("#nav_freshman").css("border-radius","10px 10px 0px 0px") ;
 //  	$("#nav_active,#nav_document,#nav_relation").css("background","none") ;
 //  	$("#ajaxDiv").css("border-radius","0px 10px 10px 10px") ;

	// $("#fre_leftcolumn,#fre_rightcolumn").children().each(function(){
	// 	$(this).attr("onclick","select('"+$(this).attr("id")+"','"+$(this).parent().parent().attr("id")+"')");//傳入兩個參數給select
	// 	$(this).hover(function(){$(this).css("text-shadow", "#87CEEB 1px 3px")
	// 	    			},function(){$(this).css("text-shadow", "none")});
						
	// 	$(this).click(function(){$.jumpWindow($("#data"))});//lightbox的效果
	// });//each()讓所有的子項目都做這件事
	//     //attr()改變attribute的屬性
	
	// function select(receiptor,category){
	
 //       jQuery.ajax({'success':function(data){                                     
 //                                        $("#data").html(data).slideDown(500).animate({opacity: 1.0},500);
 //                                    },
 //                      'type': 'GET',
 //                      'url': <?php echo "'".$this->createUrl('freshmanread/AjaxFreshmanreadData')."'"; ?>  ,
 //                      'data' : { 'receipt' : receiptor , 'category' : category } ,
 //                      'cache':false});
 //     }