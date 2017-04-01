<?php
//create a link
echo  CHtml::link('link text goes here',"#data", array("id"=>"fancy-link")); 
 
//put fancybox on page
$this->widget('application.extensions.fancybox.EFancyBox', array(
        'target'=>'a#fancy-link',
        'config'=>array(),));  
?>  
 
//use nested div structure as below
<div style="display:none">
<div id="data">
<p>Contents of this div appear in fancybox</p>
</div>
</div>