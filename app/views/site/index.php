<?php
	$bUrl=Yii::app()->request->baseUrl;
	$cs=Yii::app()->clientScript;
	$cs->registerCSSFile(Yii::app()->baseUrl.'/css/index.css');
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/app/js/calendar.js');

	$cs->registerScript('calendar', '
        var UrlData = '.CJSON::encode($this->createUrl('freshmanread/AjaxFreshmanreadData')).' ;
    ',CClientScript::POS_HEAD);
?>

<?php echo Html::blockHead('cnt','block');?>
<?php /*echo $hotvideoid; */?>
<?php 
	// use it in id=bottomwords
	$rangeModel = new CalendarForm ;
	$length = $rangeModel -> getLength() ;

	//use it in id=eventDisplay 從model取值
	for(  $a=0 ; $a<count($arrayValue) ; $a++  ){
		$firstday[$a]=$arrayValue[$a]['firstday'] ;
		$finalday[$a]=$arrayValue[$a]['finalday'] ;
		$event[$a]=$arrayValue[$a]['event'] ;//use it in id=index_hot_body
		$first_day[$a]=$arrayValue[$a]['first_day'] ;//use it in id=index_hot_body
		$final_day[$a]=$arrayValue[$a]['final_day'] ;//use it in id=index_hot_body
		$id[$a]=$arrayValue[$a]['id'] ;//use it in id=index_hot_body
		$longname_event[$a]=$arrayValue[$a]['longname_event'] ;//use it in id=index_hot_body
	}
	$widthModel = new CalendarForm ;
	list($width, $leftlength, $rightlength, $hint, $document, $filename) = $widthModel -> getAllMessage( $firstday, $finalday ) ;

	//use it in id=index_hot_body
	list($todayEvent, $eventNumber, $ID) = $widthModel -> getResentEvent( $first_day, $final_day, $longname_event ) ;
?>

		<div class="cnt" style="width: 800px; height: 200px; margin: 0 auto;">
			<img id="index_Announcement" style="width: 800px; height: 200px;" src="<?php echo $bUrl?>/file/img/Announcement.jpg" />
		</div>
		
		<div class="cnt" id="cnt_left">
			<div class="cnt_blk">
				<div class="cnt_blk_head" id="index_hot"></div>
				<div class="cnt_blk_wide_body" id="index_hot_body">
					<div id="recentThings" style="width:220px ; margin-left:15px ;">
						<p style="font-weight:bold">今天是：<?php echo date('Y/m/d D') ?></p>
						<?php
							echo '今日事項：<br/>';
							if( floor((time()-strtotime('2013-08-04 00:00:00'))/86400)==2 ){
								echo '知訊網上線' ;
							}
							echo "<div id=\"resentThing\">" ;     
							for( $a=0 ; $a<$eventNumber ; $a++ ){
								 echo "<div class=\"btn-link\" id=\"num". $ID[$a] ."\" document=\"".$document[$ID[$a]]."\" filename=\"".$filename[$ID[$a]]."\" style=\"cursor:pointer\" >".
								 $todayEvent[$a] ."(".$firstday[$ID[$a]]."~".$finalday[$ID[$a]].")". "</div>";
							}
							echo '<br/>最近事項：<br/>';
							if($eventNumber==0){
								echo "<div class=\"btn-link\" id=\"num0\" document=\"".$document[0]."\" filename=\"".$filename[0]."\" style=\"cursor:pointer\">" .
								$longname_event[0]."(".$firstday[0]."~".$finalday[0].")</div>" ;
							}
							else if($eventNumber!=0 && ($ID[$eventNumber-1]+1)!=17  ){
								echo "<div class=\"btn-link\" id=\"num". ($ID[$eventNumber-1]+1) ."\" document=\"".$document[$ID[$eventNumber-1]+1]."\" filename=\"".$filename[$ID[$eventNumber-1]+1]."\" style=\"cursor:pointer\">" . 
								$longname_event[$ID[$eventNumber-1]+1]."(".$firstday[$ID[$eventNumber-1]+1]."~".$finalday[$ID[$eventNumber-1]+1].")</div>" ;
							}
							echo "</div>" ;
						?>
					</div>
					
				</div>
				<div class="cnt_blk_wide_btm"></div>
			</div>
			<div class="cnt_blk">
				<div class="cnt_blk_head" id="index_video"></div>
				<div class="cnt_blk_wide_body" id="index_video_body">
					<?php
					echo CHtml::tag('div',array('id'=>'hotvid'),'',false);
						echo CHtml::tag('iframe',array('width'=>'100%','src'=>"//www.youtube.com/embed/".video_videoid::model()->gethotvideoid(4)."?rel=0&wmode=transparent" ),'',false);
						echo CHtml::closeTag('iframe');
						echo CHtml::link('前往影音專區',Yii::app()->baseUrl.'/video/Hotvideo/'.video_videoid::model()->gethotvideoid(4).'.html',array('class'=>'btn-link'));
					echo CHtml::closeTag('div');
					?>
				</div>
				<div class="cnt_blk_wide_btm"></div>
			</div>
		</div>


		<div class="cnt" id="cnt_center">
			<div id="index_calender">
				<div id="index_calendar_head"></div>
				
				<div id="index_calendar_body" >
					<img id="calendar_leftarrow" src="./file/img/leftarrow.gif" style="cursor:pointer" >
				
					<div id="datecontent">
						<div id="bottomwords" style="width:11907px; height:19px ; position:absolute;">							
							<div id="dateDisplay">
							<?php
								for( $num=0 ; $num<182 ; $num++ ){
									echo "<div class=\"date\">"
									.date('m/d',strtotime('2013-08-04 00:00:01')+24*60*60*$num)."</div>" ;
								}	
							?>
							</div>

							<div id="eventDisplay" style="margin-top:18px ; position:relative;">
								<?php
								
								//從model取值
								for(  $a=0 ; $a<count($arrayValue) ; $a++  ){
									$firstday[$a]=$arrayValue[$a]['firstday'] ;
									$finalday[$a]=$arrayValue[$a]['finalday'] ;
								}
								$widthModel = new CalendarForm ;
								list($width, $leftlength, $rightlength, $hint) = $widthModel -> getAllMessage( $firstday, $finalday ) ;
								//排版

								echo "<div class=\"divEventContent\" style=\" background-color:#F5FF3C; margin-left:122px; width:45px;\"><p class=\"eventContent\" style=\"font-weight:bold;cursor:default\" >知訊網<br/>上線</p></div>" ;

								for( $a=0 ; $a<count($arrayValue) ; $a++ ){
									if ( $a==0||$a==5||$a==6||$a==9||$a==13||$a==15 || $a == 17){
										echo "<div id=\"divNumber". $a ."\" class=\"divEventContent\" style=\"  background-color:#F5FF3C; margin-left:". $leftlength[$a]."px; width: ".$width[$a] ."px ; \">
												<p id=\"number". $a ."\" class=\"eventContent\"  data-original-title=\"".$hint[$a]."\" data-placement=\"left\" document=\"".$document[$a]."\" filename=\"".$filename[$a]."\" >".
												$arrayValue[$a]['event']."</p></div>" ;
									}
									else if ( $a==1||$a==8||$a==7||$a==10||$a==14||$a==16 ){
										echo "<div id=\"divNumber". $a ."\" class=\"divEventContent\" style=\" margin-top:26px;background-color:#F5FF3C;margin-left:". $leftlength[$a]."px; width: ".$width[$a] ."px ; \">
												<p id=\"number". $a ."\" class=\"eventContent\" Title=\"".$hint[$a]."\" data-placement=\"right\" document=\"".$document[$a]."\" filename=\"".$filename[$a]."\" >".
												$arrayValue[$a]['event']."</p></div>" ;
									}
									else if ( $a==2||$a==3||$a==12||$a==11 ){
										echo "<div id=\"divNumber". $a ."\" class=\"divEventContent\" style=\" margin-top:52px; background-color:#F5FF3C; margin-left:". $leftlength[$a]."px; width: ".$width[$a] ."px ; \">
												<p id=\"number". $a ."\" class=\"eventContent\" class=\"eventContent\" Title=\"".$hint[$a]."\" data-placement=\"right\" document=\"".$document[$a]."\" filename=\"".$filename[$a]."\" >".
												$arrayValue[$a]['event']."</p></div>" ;
									}
									else if ( $a==4 ){
										echo "<div id=\"divNumber". $a ."\" class=\"divEventContent\" style=\" margin-top:78px; background-color:#F5FF3C ; margin-left:". $leftlength[$a]."px; width: ".$width[$a] ."px ; \">
												<p id=\"number". $a ."\" class=\"eventContent\" Title=\"".$hint[$a]."\" document=\"".$document[$a]."\" filename=\"".$filename[$a]."\" >".
												$arrayValue[$a]['event']."</p></div>" ;
									}	
								}
								?> 					
							</div>


						</div>
					</div>
					
					<img id="calendar_rightarrow" src="./file/img/rightarrow.gif" style="height:80px ;position:absolute;margin-top:30px ; margin-left:460px; cursor:pointer ">
				</div>
				<div id="index_calendar_btm"></div>


			</div>
			<div class="cnt" id="cnt_center_bottom">
				<div class="cnt_blk">
					<div class="cnt_blk_head" id="index_news"></div>
					<div class="cnt_blk_wide_body" id="index_news_body">
						<div id="news" class="link_content">
							<?php
								$this->widget('zii.widgets.CListView', array(
									'dataProvider'=>$newsProvider,
									'itemView'=>'_item',
									'summaryText'=>'',
									'ajaxUpdate'=>true,
									'enablePagination'=>true,
									// 'pagerCssClass' => 'result-list',
									'pager'        => array(
		                                'class'          => 'CLinkPager',
		                                'header'		 => '',
		                                'firstPageLabel' => '<<',
		                                'prevPageLabel'  => '<',
		                                'nextPageLabel'  => '>',
		                                'lastPageLabel'  => '>>',
		                              ),
								));
							?>
						</div>
					</div>
					<div class="cnt_blk_wide_btm"></div>
				</div>
				<div class="cnt_blk">
					<div class="cnt_blk_head" id="index_forum"></div>
					<div class="cnt_blk_wide_body" id="index_forum_body">
						<div class="link_content">
							<div class="items">
								<?php
									foreach ($hotarticle as  $articleItem) { 
									echo '<div class="item">'.
											'<div class="title">'.
											'<a class="btn-link" href="'.CHtml::encode($articleItem['url']).'">['.CHtml::encode($articleItem['sortTag']).']'. CHtml::encode($articleItem['title']).'</a></div>'.
											'<div class="time">'.date('m/d',strtotime(CHtml::encode($articleItem['postTime']))).'</div>'.
										 '</div><br/>';
									} ?>
								[<a class="btn-link" href="<?php echo Yii::app()->createUrl('forum/index');?>">點我到新生論壇</a>]
							</div>
						</div>
					</div>
					<div class="cnt_blk_wide_btm"></div>
				</div>
			</div>
		</div>
		<div class="cnt" id="cnt_right">
			<div class="cnt_blk">
				<div class="cnt_blk_head" id="index_oftenlink"></div>
				<div class="cnt_blk_narrow_body" id="index_oftenlink_body">
					<ul>
			            <li>
			                <a class="btn-link" target=_blank href="http://www.ncu.edu.tw" title="中大首頁">中大首頁</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://portal.ncu.edu.tw" title="Portal入口">Portal入口</a>
			            </li>
			            <li
>			                <a class="btn-link" target=_blank href="http://course.ncu.edu.tw" title="選課系統">選課系統</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://bb.ncu.edu.tw" title="BlackBoard">BlackBoard</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="https://uncia.cc.ncu.edu.tw/dormnet/" title="宿網系統">宿網系統</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://volley.cc.ncu.edu.tw:8080/RepairSystem" title="宿舍修繕">宿舍修繕</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://www.lib.ncu.edu.tw" title="圖書館首頁">圖書館首頁</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://passport.ncu.edu.tw/" title="服務學習網">服務學習網</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://www.cc.ncu.edu.tw/~ncu7221/Learning/Learning_index.php" title="大一週會報名">大一週會報名</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://love.adm.ncu.edu.tw/center/Gender_Equal/main/index.html" title="性別平等教育">性別平等教育</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://www.oaa.ncu.edu.tw/ep/" title="數位學習歷程平台">數位學習歷程平台</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://140.115.184.185/OSA-3I/" title="學生跨領域3I交流活">學生跨領域3I交流活</a>
			            </li>
			        </ul>
				</div>
				<div class="cnt_blk_narrow_btm"></div>
			</div>
			<div class="cnt_blk">
				<div class="cnt_blk_head" id="index_recommend"></div>
				<div class="cnt_blk_narrow_body" id="index_recommend_body">
					<ul>
			            <li>
			                <a class="btn-link" target=_blank href="http://radio.pinewave.tw" title="松濤電台">松濤電台</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://www4.is.ncu.edu.tw/register/check/stdno_check.php" title="學號查詢">學號查詢</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://www.uac.edu.tw" title="線上查榜">線上查榜</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://ncugrad.pixnet.net/blog" title="研究生部落">研究生部落</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="https://www.facebook.com/groups/281226572008401/" title="愛上中央大學FB">愛上中央大學FB</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://ncutv.ncu.edu.tw/" title="小中大電視台">小中大電視台</a>
			            </li>
			            <li>
			                <a class="btn-link" target=_blank href="http://www.facebook.com/NCU.Seed.Volunteer" title="服務學習種子志工">服務學習種子志工</a>
			            </li>
						 <li>
			                <a class="btn-link" target=_blank href="http://ppt.cc/RnOB" title="國立中央大學2013研究生新生座談">2013研究生新生座談</a>
			            </li>
			        </ul>
				</div>
				<div class="cnt_blk_narrow_btm"></div>
			</div>
		</div>

<?php echo Html::blockBottom('cnt','block');?>

