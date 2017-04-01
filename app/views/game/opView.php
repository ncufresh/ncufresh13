<?php
/**
 * Created by IntelliJ IDEA.
 * User: Green
 * Date: 2013/7/19
 * Time: 下午 12:39
 */
echo "<br/><br/><br/><br/><br/>";
foreach($shop as $card){
	echo CHtml::ajaxButton($card['name'], "/game/ajaxOp/".$card['cid'].'.html', array("TYPE" => "GET","success" => "function(data){console.log(data);}"))."<br />";
}