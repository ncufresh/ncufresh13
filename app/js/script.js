

(function($)
{
    $.konami = function(options)
    {
        var options = $.extend({
            code:                   [38, 38, 40, 40, 37, 39, 37, 39],
            interval:               10,
            complete:               function()
            {
               alert("you complete a konami code");
            }
        }, options);
        var index = 0;
        var interval = options.interval;
        var timer = setInterval(function()
        {
            if ( interval-- <= 0 ) index = 0;
        }, 50);
        $(document).keyup(function(event)
        {
            if (
                event.keyCode != 231
             && event.keyCode == options.code[index]
            )
            {
                interval = options.interval;
                if ( index++ == options.code.length - 1 ) options.complete();
                return true;
            }
            index = 0;
            return true;
        });
    };
})(jQuery);


/*
跳出視窗
*/
(function($)
{
    $.jumpWindow = function(options)
    {

        var content = $('<div id="divShow"></div>').html(options);
        var box     = $('<div id="jumpWrapped"></div>').html(content).prepend('<div id="close"></div>');

        $("#back").html(box).promise().done(function() {
            $("#close").click(function() {
                $.jumpWindowClose();
            });

            $("#back").fadeIn('slow',function(){
			});
			box.css({
				width: parseInt(options.css('width').replace("px", "")) + parseInt(options.css('paddingLeft').replace("px", "")) + parseInt(options.css('paddingRight').replace("px", "")) +'px',
				height: options.css("height") + parseInt(options.css('paddingTop').replace("px", "")) + parseInt(options.css('paddingBottom').replace("px", "")) +'px'
			});
		});
        
    }
})(jQuery);


/*
跳出視窗關閉
*/
(function($)
{
	$.jumpWindowClose = function(options)
	{
		$("#back").fadeOut('slow',function() {
            $("#back").empty();
        });
		
	}
})(jQuery);

/**
* Animate for block
*/
function animate(blkID,html,callback){
    $warpped=$("#"+blkID+"_warpped");
    $head=$("#"+blkID+"_head");
    $body=$("#"+blkID+"_body");
    $btm=$("#"+blkID+"_btm");

    if($warpped.is(":visible")){
        animateClose(blkID,true,true,html,blkID,callback);
    }else{
        animateOpen(blkID,html,callback);
    }

};

function animateOpen(blkID,html,callback){
    var speed=500;
    $warpped=$("#"+blkID+"_warpped");
    $head=$("#"+blkID+"_head");
    $body=$("#"+blkID+"_body");
    $btm=$("#"+blkID+"_btm");
    $body.html(html).promise().done($(function(){
                $warpped.slideDown(speed,function(){
                    if($("#"+blkID+"_close")){
                        $("#"+blkID+"_close").fadeIn(speed);
                    }
                    $.bar($("#bodyscroll"));
                    goTop();
                    if(typeof callback == 'function')
                        callback.call();
                });
            }));
}

/*
 回到最頂端
 */
function goTop(acceleration, time, preY, targetY) {
	var target;
	if(!targetY)
	{
		for(var i=0;i<$('.cnt_warpped').length;i++){
			if($($('.cnt_warpped')[i]).is(':visible'))
			{
				//console.log($('.cnt_warpped')[i]);
				target = -($($('.cnt_warpped')[i]).position().top);
				break;
			}
		};
	}
	target = target || targetY;
	acceleration = acceleration || 0.9;
	time = time || 16;
	var y = parseInt($('#bodywrapped').css('top').replace("px", ""));
	var dst = target-y;
	var preY = preY || y;
	if(preY>y) // user scroll page
		return;
	var speed = 1 + acceleration;
	var pos = Math.floor(parseFloat(dst)/speed)+y;
	$('#bodywrapped').css('top', pos+'px');
	if(Math.abs(dst)>5) {
		var invokeFunction = "goTop(" + acceleration + ", " + time + ", " + pos + ", " + target +")";
		window.setTimeout(invokeFunction, time);
	}
}



/**
* A function to close block
**/
function animateClose(blkID,clear,reopen,html,newBlkID,callback){
    newBlkID=newBlkID||blkID;
    var speed=500;
    $warpped=$("#"+blkID+"_warpped");
    $head=$("#"+blkID+"_head");
    $body=$("#"+blkID+"_body");
    $btm=$("#"+blkID+"_btm");
    

    $body.find('*').animate({opacity: 0.0},{
                duration: speed
            });
    $("#"+blkID+"_close").fadeOut(speed);
     setTimeout(function close(){
                goTop();
                $warpped.slideUp(speed,function(){
			        $.bar($("#bodyscroll"));
                    if(clear)
                        $body.html('');
                    if(reopen)
                        animateOpen(newBlkID,html,callback);
                });
                },speed+200);
}



     
/*
*通知訊息
*/
function alertMsg(content,title,status){
    title=title||'';
    status=status||'normal';
    switch(status){
        case "error":
             $(".alert").css({'backgroundColor': '#FFFFFF','border': '1px solid #FF0000','color':'#FF0000'});
             break;
        case "normal":
             $(".alert").css({'backgroundColor': '#FFFFFF','border': '1px solid #0000A0','color':'#0000A0'});
             break;

    }
    $(".alert").html('');
    $(".alert strong").html(title);
    $(".alert").append(content);
                    // $(".alert").alert();
    $(".alert").fadeIn(700,function() {
        $(".alert").delay(3000).queue(function(next) {
            $(".alert").fadeOut(700,function() {
                $(this).html('<strong></strong>');
            });
            
            next();
        })
        });
}


/**
 * Mousewheel
 */
(function($)
{
    var types = ['DOMMouseScroll', 'mousewheel'];
	
    var handler = function(event) {
        var orgEvent = event || window.event, args = [].slice.call(arguments, 1);
        var delta = 0;
        var deltaX = 0;
        var deltaY = 0;
        var returnValue = true;

        event = $.event.fix(orgEvent);
        event.type = 'mousewheel';

        if ( orgEvent.wheelDelta ) delta = orgEvent.wheelDelta / 120;
        if ( orgEvent.detail ) delta = -1 * orgEvent.detail / 3;

        deltaY = delta;

        if (
            orgEvent.axis !== undefined
         && orgEvent.axis === orgEvent.HORIZONTAL_AXIS
        )
        {
            deltaY = 0;
            deltaX = -1 * delta;
        }

        if ( orgEvent.wheelDeltaY !== undefined )
        {
            deltaY = orgEvent.wheelDeltaY / 120;
        }
        if ( orgEvent.wheelDeltaX !== undefined )
        {
            deltaX = -1 * orgEvent.wheelDeltaX / 120;
        }

        args.unshift(event, delta, deltaX, deltaY);
        return ($.event.dispatch || $.event.handle).apply(this, args);
    }

    if ( $.event.fixHooks )
    {
        for ( var i = types.length ; i ; )
        {
            $.event.fixHooks[types[--i]] = $.event.mouseHooks;
        }
    }

    $.event.special.mousewheel = {
        setup: function()
        {
            if ( this.addEventListener )
            {
                for ( var i = types.length ; i ; )
                {
                    this.addEventListener(types[--i], handler, false);
                }
            }
            else
            {
                this.onmousewheel = handler;
            }
        },
        teardown: function()
        {
            if ( this.removeEventListener )
            {
                for ( var i = types.length ; i ; )
                {
                    this.removeEventListener(types[--i], handler, false);
                }
            }
            else
            {
                this.onmousewheel = null;
            }
        }
    };

    $.fn.extend({
        mousewheel: function(fn)
        {
            return fn ? this.bind('mousewheel', fn) : this.trigger('mousewheel');
        },
        unmousewheel: function(fn)
        {
            return this.unbind('mousewheel', fn);
        }
    });
})(jQuery);




(function($)
{
    $.bar=function(div,refresh,options)
    {
        $.createBar(div,refresh,options);
        $('body').waitForImages({
            waitForAll: true, 
            finished: function() {
                $.createBar(div,refresh,options);
            }
        });
    }
}
)(jQuery);



	/*
		div傳進來的top在CSS要給值
	*/
(function($)
{
    $.createBar = function(div,refresh,options)
    {
		// console.dir(div);
    	var options = $.extend({
    		scale:		0,
			scaleW:		0,
    		hold:		false,
			hold2:		false,
    		holdY:		0,
			holdW:		0,
    		cnt:		div.children(),
    		cntH:		parseInt(div.children().css("height").replace("px","")),
			cntW:		parseInt(div.children().css("width").replace("px","")),
    		divH:		parseInt(div.css("height").replace("px","")),
			divW:		parseInt(div.css("width").replace("px",""))
    	}, options);
    	if(div.children("#scrollbar").length != 0)
    	{
    		div.children("#scrollbar").fadeOut().remove();
    		div.unmousewheel();
    	}
		if(div.children("#scrollbarW").length != 0)
    	{
    		div.children("#scrollbarW").fadeOut().remove();
    		div.unmousewheel();
    	}
		if(refresh)
		{
			options.cnt.css({
				top: '0px',
				left: '0px'
			});
		}
    	if( options.cntH > options.divH)
    	{

    		options.scale = options.divH/options.cntH;
    		options.hold = false;
    		options.holdY = 0;
			var index = 0;
			if(!refresh)
			{
				index = (0-parseInt(options.cnt.css("top").replace("px","")))*options.scale*9/10;
				if( parseInt(options.cnt.css("top").replace("px","")) + options.cntH < options.divH )
				{
					options.cnt.css({
						top: '0px'
					});
					index = 0;
				}
			}
    		$("body").mouseup(function(){
    			options.hold = false;
    		});
    		var box = $('<div id="scrollbar"></div>').css({
    			width: '25px',
    			height: '95%',
    			float: 'right',
    			right: '0px',
    			zIndex: '20',
    			top: '5%',
    			position: 'absolute'
    		}).mouseenter(function(){
    			whiteBack.fadeIn();
    		}).mouseleave(function(){
    			if(!options.hold)
    			{
    				whiteBack.fadeOut();
    				options.hold = false;
    			}
    		}).mouseup(function(){
    			options.hold = false;
    		}).appendTo(div);
    		var whiteBack = $('<div></div>').css({
    			background: 'rgba(255,255,255,0.5)',
    			width: '10px',
    			height: '90%',
    			float: 'right',
    			right: '15px',
    			zIndex: '20',
    			top: '5%',
    			position: 'absolute',
    			borderRadius: '10px'
    		}).click(function(event){
    			var t = event.pageY - whiteBack.offset().top - parseInt(black.css("height").replace("px",""))/2;
    			if(t<0)
    			{
    				t = 0;
    				black.animate({
    					top: '0px'
    				});
    				options.cnt.animate({
    					top: '0px'
    				})
    			}
    			else if(event.pageY - whiteBack.offset().top - t + parseInt(black.css("height").replace("px","")) > parseInt(whiteBack.css("height").replace("px","")) )
    			{
    				t = parseInt(whiteBack.css("height").replace("px","")) - parseInt(black.css("height").replace("px",""));
    				black.animate({
    					top: parseInt(whiteBack.css("height").replace("px","")) - parseInt(black.css("height").replace("px","")) +'px'
    				});
    				options.cnt.animate({
    					top: 0 -(options.cntH-options.divH) +'px'
    				});
    			}
    			else
    			{
    				black.animate({
    					top: t +'px'
    				});
    				options.cnt.animate({
    					top: (0 - t/options.scale*10/9) +'px'
    				})
    			}
    		}).hide().appendTo(box);
    		var black = $('<div></div>').css({
    			background: 'rgba(0,0,0,0.5)',
    			width: '100%',
    			height: options.scale * parseInt(whiteBack.css("height").replace("px","")) +'px',
    			float: 'right',
    			top: index + 'px',
    			position: 'absolute',
    			borderRadius: '10px'
    		}).mousedown(function(event){
    			options.hold = true;
    			options.holdY = event.pageY - whiteBack.offset().top - parseInt(black.css("top").replace("px",""))
    		}).appendTo(whiteBack);
    		div.mousemove(function(event){
    			if(options.hold){
    				var t = event.pageY - whiteBack.offset().top - options.holdY;
    				if(t<0)
    				{
    					t = 0;
    					black.css({
    						top: '0px'
    					});
    					options.cnt.css({
    						top: '0px'
    					})
    				}
    				else if(event.pageY - whiteBack.offset().top - options.holdY + parseInt(black.css("height").replace("px","")) > parseInt(whiteBack.css("height").replace("px","")) )
    				{
    					t = parseInt(whiteBack.css("height").replace("px","")) - parseInt(black.css("height").replace("px",""));
    					black.css({
    						top: parseInt(whiteBack.css("height").replace("px","")) - parseInt(black.css("height").replace("px","")) +'px'
    					});
    					options.cnt.css({
    						top: 0 -(options.cntH-options.divH) +'px'
    					});
    				}
    				else
    				{
    					black.css({
    						top: t +'px'
    					});
    					options.cnt.css({
    						top: (0 - t/options.scale*10/9) +'px'
    					})
    				}
    			}
    		}).mousewheel(function(event, delta){
    			for(var i = 0;i<$(event.target).parents().length;i++)
    			{
    				if($(event.target).parents().eq(i).children("#scrollbar").length != 0)
    				{
    					if($(event.target).parents().eq(i).attr("id") == div.attr("id"))
    					{
    						var move = delta*30;
    						if( parseInt(options.cnt.css("top").replace("px","")) + move >= 0 )
    						{
    							black.css({
    								top: '0px'
    							});
    							options.cnt.css({
    								top: '0px'
    							});
    						}
    						else if(parseInt(options.cnt.css("top").replace("px","")) + options.cntH + move <= options.divH)
    						{
    							black.css({
    								top: parseInt(whiteBack.css("height").replace("px","")) - parseInt(black.css("height").replace("px","")) +'px'
    							});
    							options.cnt.css({
    								top: 0 -(options.cntH-options.divH) +'px'
    							});
    						}
    						else
    						{
    							black.css({
    								top: '-=' + (move*options.scale/10*9) +'px'
    							});
    							options.cnt.css({
    								top: '+=' + move +'px'
    							});
    						}
    					}
    					break;
    				}
    			}
    		});
    	}
		if( options.cntW > options.divW)
    	{
    		options.scaleW = options.divW/options.cntW;
    		options.hold2 = false;
    		options.holdW = 0;
			var indexW = 0;
			if(!refresh)
			{
				indexW = (0-parseInt(options.cnt.css("left").replace("px","")))*options.scaleW*9/10;
				if( parseInt(options.cnt.css("left").replace("px","")) + options.cntW < options.divW )
				{
					options.cnt.css({
						left: '0px'
					});
					indexW = 0;
				}
			}
    		$("body").mouseup(function(){
    			options.hold2 = false;
    		});
    		var boxW = $('<div id="scrollbarW"></div>').css({
    			width: '95%',
    			height: '50px',
    			float: 'bottom',
    			bottom: '0px',
    			zIndex: '20',
    			left: '2%',
    			position: 'absolute'
    		}).mouseenter(function(){
    			whiteBackW.fadeIn();
    		}).mouseleave(function(){
    			if(!options.hold2)
    			{
    				whiteBackW.fadeOut();
    				options.hold2 = false;
    			}
    		}).mouseup(function(){
    			options.hold2 = false;
    		}).appendTo(div);
    		var whiteBackW = $('<div></div>').css({
    			background: 'rgba(255,255,255,0.5)',
    			width: '90%',
    			height: '10px',
    			float: 'top',
    			top: '15px',
    			zIndex: '20',
    			left: '5%',
    			position: 'absolute',
    			borderRadius: '10px'
    		}).click(function(event){
    			var t = event.pageX - whiteBackW.offset().left - parseInt(blackW.css("width").replace("px",""))/2;
    			if(t<0)
    			{
    				t = 0;
    				blackW.animate({
    					left: '0px'
    				});
    				options.cnt.animate({
    					left: '0px'
    				})
    			}
    			else if(event.pageX - whiteBackW.offset().left - options.holdW + parseInt(blackW.css("width").replace("px","")) > parseInt(whiteBackW.css("width").replace("px","")) )
    			{
    				t = parseInt(whiteBackW.css("width").replace("px","")) - parseInt(blackW.css("width").replace("px",""));
    				blackW.animate({
    					left: parseInt(whiteBackW.css("width").replace("px","")) - parseInt(blackW.css("width").replace("px","")) +'px'
    				});
    				options.cnt.animate({
    					left: 0 -(options.cntW-options.divW) +'px'
    				});
    			}
    			else
    			{
    				blackW.animate({
    					left: t +'px'
    				});
    				options.cnt.animate({
    					left: (0 - t/options.scaleW*10/9) +'px'
    				})
    			}
    		}).hide().appendTo(boxW);
    		var blackW = $('<div></div>').css({
    			background: 'rgba(0,0,0,0.5)',
    			height: '100%',
    			width: options.scaleW * parseInt(whiteBackW.css("width").replace("px","")) +'px',
    			float: 'top',
    			left: index + 'px',
    			position: 'absolute',
    			borderRadius: '10px'
    		}).mousedown(function(event){
    			options.hold2 = true;
    			options.holdW= event.pageX - whiteBackW.offset().left - parseInt(blackW.css("left").replace("px",""))
    		}).appendTo(whiteBackW);
    		div.mousemove(function(event){
    			if(options.hold2){
    				var t = event.pageX - whiteBackW.offset().left - options.holdW;
    				if(t<0)
    				{
    					t = 0;
    					blackW.css({
    						left: '0px'
    					});
    					options.cnt.css({
    						left: '0px'
    					})
    				}
    				else if(event.pageX - whiteBackW.offset().left - options.holdW + parseInt(blackW.css("width").replace("px","")) > parseInt(whiteBackW.css("width").replace("px","")) )
    				{
    					t = parseInt(whiteBackW.css("width").replace("px","")) - parseInt(blackW.css("width").replace("px",""));
    					blackW.css({
    						left: parseInt(whiteBackW.css("width").replace("px","")) - parseInt(blackW.css("width").replace("px","")) +'px'
    					});
    					options.cnt.css({
    						left: 0 -(options.cntW-options.divW) +'px'
    					});
    				}
    				else
    				{
    					blackW.css({
    						left: t +'px'
    					});
    					options.cnt.css({
    						left: (0 - t/options.scaleW*10/9) +'px'
    					})
    				}
    			}
    		});
    	}
    }
})(jQuery);
/**
 * Main
 */
(function($)
{
	var initWidth = $(window).width();
    function tick(){
        $('.head_ul :first-child').each(function() {
           $(this).slideUp( function () { $(this).appendTo($(this).parent('.head_ul')).slideDown(); });
        });
      //  console.dir($('.head_ul'));
    }

    $(document).ready(function()
    {//roachmaycry
		$.konami({
			code:                   [82, 79, 65, 67, 72, 77, 65, 89, 67, 82, 89],
			interval:		100,
            complete:		function(){
				$.getScript(bUrl+"/app/js/RMC.js")
			}
		});
		$("#bodyscroll").css({
			height: $(window).height(),
			width: $(window).width()
		});
		$.bar($("#bodyscroll"));
        $("#back").click(function(evt){
            if($(evt.target).parents("#divShow").length == 0 && evt.target.id != "divShow") {
                $.jumpWindowClose();
            }
        });
        $(document).bind("keyup", function (e) {
            if(e.keyCode===27)
                $.jumpWindowClose();
        });

        setInterval(function(){tick();},3000);

        $("body").bind("ajaxSend", function(elm, xhr, s){
           if (s.type == "POST") {
                s.data='YII_CSRF_TOKEN='+csrf_token+'&'+s.data;
           }
        });
    });
	$(window).load(function()
    {
		$("#bodywrapped").css({
			width: $(window).width(),
			marginLeft: (parseInt($("#bodyscroll").css("width").replace("px",""))/2 - initWidth/2) + 'px'
		});
		$.bar($("#bodyscroll"));
    });
    
	$(window).resize(function(){
		$("#bodyscroll").css({
			height: $(window).height() ,
			width: $(window).width()
		});
		
		$("#bodywrapped").css({
			marginLeft: (parseInt($("#bodyscroll").css("width").replace("px",""))/2 - initWidth/2) + 'px'
		});
		$.bar($("#bodyscroll"),true);
		$("#scrollbar").each(function(index){
			$.bar($(this).parent(),true);
		})
	});

})(jQuery);