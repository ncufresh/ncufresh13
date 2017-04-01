<?php $cs=Yii::app()->clientScript;
      $bUrl=Yii::app()->request->baseUrl;
      $cs->registerCSSFile($bUrl.'/css/reminder.css');
      $cs->registerScriptFile($bUrl.'/app/js/freshmanread/reminder.js');// import js file

      $cs->registerScript('reminder', '
        var UrlReminder2 = '.CJSON::encode($this->createUrl('freshmanread/reminder2')).';
        var UrlAjax = '.CJSON::encode($this->createUrl('freshmanread/Ajax')).' ;
        var UrlData = '.CJSON::encode($this->createUrl('freshmanread/AjaxFreshmanreadData')).' ;
    ',CClientScript::POS_HEAD);// import js file

?>

<?php echo Html::blockHead('cnt','block');?>
<div id="outer" style="height:550px; width:960px; margin: 0 auto ; ">

  <div id="wrapped" >
<!--   <div style="background:#98bf21;height:490px;width:960px;position:absolute;"></div> 檢測可用 -->
      <div style="margin: 0 auto">
        <img class="image"  src="<?php echo $bUrl?>/file/img/freshmanread/freshmanread.png" style="height:90px ; margin-left:336px" >
      </div>
      
      <div id="navigation" style=" margin-left:50px ; height:85px ; width:852">
      </div>


      <div id="ajaxDiv" style="background-color:#FFCB7D"  onmouseover="this.style.overflowY='auto'" onmouseout="this.style.overflowY='hidden'" >     
      </div>
     
      <div id="data"></div>

      <div id='selectWrapped' style="position:relative;height:100%">

        <div id="freshman" class='imgWrapped'>
          <img id="freshmanImg" class="area"  src="<?php echo $bUrl?>/file/img/freshmanread/freshman.png"  >
        </div>
        
        <div id="relation" class='imgWrapped'>
          <img id="relationImg" class="area"  src="<?php echo $bUrl?>/file/img/freshmanread/relation.png"  >
          
        </div>

         <div id="active" class='imgWrapped'>
          <img id="activeImg" class="area"  src="<?php echo $bUrl?>/file/img/freshmanread/active.png"  >
        </div>
        
        <div id="document" class='imgWrapped'>
          <img id="documentImg" class="area"  src="<?php echo $bUrl?>/file/img/freshmanread/document.png"  >
        </div>
      </div>

  </div>

  

</div>

<?php echo Html::blockBottom('cnt','block');?>
  