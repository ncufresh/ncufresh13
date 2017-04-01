var flush=0;

$(function(){
	window.setInterval(function(){
		flush=0;
	}, 60000);

	setvid(vidnow);
	$('.vidblur').css({"background":"rgba(0,0,0,0.75)","cursor":"pointer"});
	$.vidbar($("#vidothersout"));
	$('#msgsubmit').css("cursor","pointer").
		mouseenter(function(){changestar()}).
		mouseleave(function(){changenormal()}).
		mousedown(function(){changegray()}).
		mouseup(function(){addmsg(vidnow)});
	$("#head_login").bind("login", function(event,data) {
    	$('#msgtop').html('<div id="msgaddin"><img id="msgaddinimg" src="'+bUrl+'/file/img/video/addmsg.png" alt="user image fuck"><div id="msgaddleft"><img id="userimg" src="' + data.imgUrl + '" alt="user image fuck"></div><div id="msgaddright"><div id="msgtaarea"><textarea rows="4" id="msgta" maxlength="40" name="msg"></textarea></div><div id="whosay"  ><img id="msgsubmit"  src="'+bUrl+'/file/img/video/submit.png"   alt="img fuck"></div></div></div>');
		$('#msgsubmit').css("cursor","pointer").
		mouseenter(function(){changestar()}).
		mouseleave(function(){changenormal()}).
		mousedown(function(){changegray()}).
		mouseup(function(){addmsg(vidnow)});
	});

});

(function($){

	$.vidbar = function($div){
		
		var hold = false;
		var frontpos = 0;
		var $vidoth = $div.children("#vidothersin");
		var scaleoth = parseInt($vidoth.css("width").replace('px',''))/parseInt($div.css("width").replace('px',''))
		var scalebar = 15/100;
		var scalebox = 1;

		var $divbox = $('#scrollbar');
		$('#scrollbar').css({
			top:'0px',
			position:'relative',
			background:'rgba(255,207,138,0)',
			width:'100%',
			left:'0px',
			height:'50px',
			borderRadius: '2px'
		});

		var $divback = $('<div id="divback"></div>').css({
			position:'absolute',
			background:'white',
			width:'100%',
			top:'20px',
			left:'0%',
			height:'10px'
		}).appendTo($divbox);

		var $divfront = $('<div id="divfront"></div>').css({
			position:'absolute',
			width:'15%',
			height:'300%',
			left:'0px',
			top:'-10px'
		}).appendTo($divback);

		$divfront.mousedown(function(event){
			frontpos=event.pageX-$divbox.offset().left-parseInt($divfront.css("left").replace('px',''));
			hold=true;
		});

		$div.mousemove(function(event){
			if(hold){
				var l= event.pageX-frontpos-parseInt($divback.offset().left);
				if(l<0){
					l=0;
					$divfront.css({
						left:'0px'
					});
					$vidoth.css({
						left:'0px'
					})
				}
				else if(l>parseInt($divback.css("width").replace('px',''))-parseInt($divfront.css("width").replace('px',''))){
					l=parseInt($divback.css("width").replace('px',''))-parseInt($divfront.css("width").replace('px',''));
					$divfront.css({
						left:l+'px'
					});
					$vidoth.css({
						left:0-parseInt($vidoth.css("width").replace('px',''))+parseInt($div.css("width").replace('px',''))
					})
				}
				else{
					$divfront.css({
						left:l+'px'
					});
					$vidoth.css({
						left: 0-(l/(parseInt($divback.css("width").replace('px',''))-parseInt($divfront.css("width").replace('px','')))*(parseInt($vidoth.css("width").replace('px',''))-parseInt($div.css("width").replace('px',''))))+'px'
					})
				}
			}
		}).mousewheel(function(event,delta){
			for(var x=0;x<$(event.target).parents().length;x++){
				if($(event.target).parents().eq(x).children("#scrollbar").length != 0 && $(event.target).parents().eq(x).attr("id") == $div.attr("id")){
					var i = delta*35;
					if(parseInt($divfront.css("left").replace("px",""))-i<0){
						$divfront.css({
							left:'0px'
						});
						$vidoth.css({
							left:'0px'
						})
					}
					else if(parseInt($divfront.css("left").replace('px',''))-i>parseInt($divback.css("width").replace('px',''))-parseInt($divfront.css("width").replace('px',''))){
						$divfront.css({
							left:parseInt($divback.css("width").replace('px',''))-parseInt($divfront.css("width").replace('px',''))+'px'
						});
						$vidoth.css({
							left:0-parseInt($vidoth.css("width").replace('px',''))+parseInt($div.css("width").replace('px',''))
						})
					}
				else{
					$divfront.css({
						left:'-='+i+'px'
					});
					$vidoth.css({
						left:'+='+ ((i/(parseInt($divback.css("width").replace('px',''))-parseInt($divfront.css("width").replace('px','')))*(parseInt($vidoth.css("width").replace('px',''))-parseInt($div.css("width").replace('px','')))))+'px'
					})
				}
				break;
				}
		
			}
		});

		$('body').mouseup(function(){
			hold=false;
		});
		

	}
})(jQuery);


