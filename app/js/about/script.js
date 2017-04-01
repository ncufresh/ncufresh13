//the javascript file of about
(function($)
{
	$.about = function(options)
    {
    	var choose;
    	var lastchoose;
    	var sw = 0;
    	var mouse = 0;
    	var timer;
    	var i = 1;
    	var item;

    	//set initial drag divs images
		$(".drag").each(function()
		{
			$(this).attr("src",bUrl+"/file/img/about/"+$(this).attr('id')+".png");
		});
		//set draggle tetris event
		$(".shape").draggable(
		{	//start to drag tetris
			start: function()
				{
					lastchoose = choose;
					choose = $(this).attr("id");	
					if (choose != 'ddeload') 
					{
						$("#dialog").css("opacity", "0");
						$("#mask").show();
						$("#mask").attr("src", bUrl+"/file/img/about/blackout_"+choose+".png");
						$("#m" + choose).css("cursor", "pointer");
						$("#m" + choose).css("z-index", "4");
						$("#dialog").css("z-index", "1");
						$("#m" + choose).mouseover(function()
						{
							mouse = 1;
						}).mouseout(function()
						{
							mouse = 0;
						});
					}
				},
			//stop dragging
			stop: function()
				{
					$("#mask").hide();
					$("#dialog").css("opacity", "1");
					$("#dialog").css("z-index", "5");
					$(".match").css("cursor", "default");
					if (choose != 'ddeload') 
					{
						if(mouse == 1 && sw == 0)
	                    {
	                    	sw = 1;
	                    	mouse = 0;
	                    	match(choose, sw);
	                    }

	                    else if(mouse == 1 && sw == 1)
	                    {
	                    	if (lastchoose != choose) 
	                    	{
		                    	back(lastchoose);
	                    	}

	                    	sw = 1;
		                    mouse = 0;
	                    	match(choose, sw);
	                    }

	                    else
	                    {
	                    	reset();
	                    }
                    }

                    else
                    {
                    	reset();
                    }
				}
		});

		$("#ddeload").unbind();
		//reset locations of tetris when deload is pressed
		$("#ddeload").click(function()
		{
			reset();
		});
		//add bar to div frame
		$.bar($("#frame"));

		
		//function to reset locations of tetris 
		function reset()
		{
			if(sw != 0)
			{
				sw = 0;
				mouse = 0;
				motionDialog('total', sw);
			}

			i = 0;
			clearInterval(timer);
			$("#dadmin").animate({"left":"48px", "top":"508px"}, "slow");
			$("#dprogram").animate({"left":"161px", "top":"508px"}, "slow");
			$("#ddesign").animate({"left":"286px", "top":"508px"}, "slow");
			$("#dmedia").animate({"left":"406px", "top":"508px"}, "slow");
			$("#dproject").animate({"left":"513px", "top":"508px"}, "slow");
			$("#dphoto").animate({"left":"633px", "top":"508px"}, "slow");
			$("#ddeload").animate({"left":"766px", "top":"530px"}, "slow");
			$(".match").css("z-index", "2");
		}
		//function to let lastchoose tetris back
		function back(lastchoose)
		{
			switch(lastchoose)
        	{
        		case 'dadmin':
        			$("#" + lastchoose).animate({"left":"48px", "top":"508px"}, "slow");
        			break;

        		case 'dprogram':
        			$("#" + lastchoose).animate({"left":"161px", "top":"508px"}, "slow");
        			break;

        		case 'ddesign':
        			$("#" + lastchoose).animate({"left":"286px", "top":"508px"}, "slow");
        			break;

        		case 'dmedia':
        			$("#" + lastchoose).animate({"left":"406px", "top":"508px"}, "slow");
        			break;

        		case 'dproject':
        			$("#" + lastchoose).animate({"left":"513px", "top":"508px"}, "slow");
        			break;

        		case 'dphoto':
        			$("#" + lastchoose).animate({"left":"633px", "top":"508px"}, "slow");
        			i = 0;
        			clearInterval(timer);
        			break;

        		default:
        			break;
        	}
		}
		//function to set the events when tetris move to match request fields
		function match(choose, sw)
		{
        	$("#m" + choose).css("z-index", "2");
			switch(choose)
        	{
        		case 'dadmin':
        			$("#" + choose).animate({"left":"86px", "top":"413px"}, "slow");
        			motionDialog(choose, sw);
        			break;

        		case 'dprogram':
        			$("#" + choose).animate({"left":"196px", "top":"441px"}, "slow");
        			motionDialog(choose, sw);
        			break;

        		case 'ddesign':
        			$("#" + choose).animate({"left":"414px", "top":"413px"}, "slow");
        			motionDialog(choose, sw);
        			break;

        		case 'dmedia':
        			$("#" + choose).animate({"left":"523px", "top":"441px"}, "slow");
        			motionDialog(choose, sw);
        			break;

        		case 'dproject':
        			$("#" + choose).animate({"left":"632px", "top":"441px"}, "slow");
        			motionDialog(choose, sw);
        			break;

        		case 'dphoto':
        			$("#" + choose).animate({"left":"797px", "top":"386px"}, "slow");
        			motionDialog(choose, sw);
        			timer = setInterval(showPhoto,4000);
        			$("#photo_1_big").hide().fadeIn("slow",function(){

        			});
        			
        			break;
        			
        		default:
        			break;
        	}
		}
		//function to show dialog
		function showDialog(choose)
		{	
			jQuery.ajax(
				{	//ajax send succeed
					'success': function(html){
		                        $("#dialog").html(html);
		                        },
	                'data': {'select': choose},
	                'url':	dialog,
	                //ajax is sending
	                'beforeSend': function(){
	                			$('<img id="loading" src=' + bUrl + '/file/img/campusTour/loading.gif>').appendTo($("#dialog"));
	                			},
	                //the page loads complete
	                'complete': function(){
	                			$("#loading").remove();

	                			},
	                'error': function(){
                			alertMsg('Error loading','','error');
                			},
	                'cache':false}).done(function()
	                {
	                	$.bar($("#frame"));
	                	$.bar($("#box"));
	        $(".item").each(function(index)
			{
				$(this).click(function(){
					item = $(this).attr("id");
					$(".photo").fadeOut("slow", function()
						{
							$("#" + item + "_big").fadeIn("slow");
						});
				});
			});
		            });
		}
		//function to close dialog
		function closeDialog()
		{
			$("#dialog").fadeOut("slow", function()
				{
					$("#dialog").empty();
				});
		}
		//funtion to request motion of dialog
		function motionDialog(choose, sw)
		{
	        closeDialog();
	        $("#dialog").fadeIn("slow", function()
				{
					showDialog(choose);
				});
		}
		//function to show photoes 
		function showPhoto()
		{
			i++;
			if(i > 25)
			{
				i = 1;
				$("#photo_25_big").fadeOut("slow", function()
					{
						$("#photo_" + i).fadeIn("slow");
					});
			}

			else
			{
				$("#photo_" + (i-1) + "_big").fadeOut("slow", function()
				{
					$("#photo_" + i + "_big").fadeIn("slow");
				});
			}
		}
	};
})(jQuery);

(function($)
{
    $(window).load(function()
    {
		$.about();
    });
})(jQuery);