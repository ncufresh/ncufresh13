var msgr=0;
var msgnext="";
var msgloading=false;
var moreclick=false;
var setting=false;
var canaddmsg=true;
function addloading(){
	$('#msgdisplayin').append('<div id="msgloading"><img id="msgloadingimg"  src="' + bUrl + '/file/img/video/msgloading.gif"></div>');
}

function droploading(){
	$('#msgloading').remove();
}

function showmsgerror(){
	
}

function setvid(videoid){

	if(!setting&&(videoid!=vidnow||msgr==0)){
		canaddmsg=true;
		setting=true;
		vidnow=videoid;
		moreclick=false;
		msgr=0;
		$('#msgdisplayin').html('').css('top','0px');
		addloading();
		$('#viddisplayin').html('<div id="vidloading" ><img id="loadingimg"  src="' + bUrl + '/file/img/video/loading.gif"></div>');
		$.getJSON(
			"https://gdata.youtube.com/feeds/api/videos/"+videoid+"?v=2&alt=json&callback=?",
			function(vidinfo){
				$("#vidinfotitle").html(vidinfo.entry.title.$t);
				$("#vidinfoview").html(vidinfo.entry.yt$statistics.viewCount);
				$("#vidtalk").html(vidinfo.entry.media$group.media$description.$t);
				$("#viddisplayin").html('<iframe width="560" height="315" src="//www.youtube.com/embed/'+videoid+'?rel=0" frameborder="0" allowfullscreen></iframe>');
			});
		getmsg(function(){showmsg();getmsg(function(){setting=false});});
	}
}

function getmsg(callback){
	msgloading=true;
	$.ajax({
		url: bUrl+'/video/showmsg.html',
		error: function(xhr) {},
		success : function(result){
			msgnext=result;
			msgr++;
			msgloading=false;
			if(moreclick){
				droploading();
				showmsg();
				moreclick=false;
				getmsg();
			}
		},
		data: {'videoid':vidnow,'msgrow':msgr},
		type : 'POST'
	}).done(callback);
}

function showmsg(){
	if(msgr==1)
		$('#msgdisplayin').html('').css('top','0px');
	$("#msgdisplayin").append(msgnext);
	$.bar($("#msgdisplay"));
}

function moremsg(){
	$("#moremsg").remove();
	if(!msgloading){
		showmsg();
		getmsg();
	}
	else{
		addloading();
		moreclick=true;
	}
}

function addmsg(videoid){
	if(!setting&&canaddmsg){
		txt=$("#msgta").val();
		if(txt.length!=0){
			$.post(bUrl+"/video/addmsg.html",{msg:txt,videoid:videoid},function(result){
				if(result==1){
					alertMsg('大哥別這樣','add msg fuck','error');
					$("#msgta").val('');
				}
				else if(result==2){
					alertMsg('大哥別亂塞','add msg fuck','error');
					$("#msgta").val('');
				}
				else if(result==3){
					alertMsg('你的留言沒意義喔','add msg fuck','error');
					$("#msgta").val('');
				}
				else if(result==4){
					alertMsg('請過一段時間之後再留言','add msg fuck','error');
					$("#msgta").val('');
				}
				else if(result==100){
					alertMsg('留言成功','add msg work','normal')
					$("#msgta").val('');
					setting=true;
					vidnow=videoid;
					moreclick=false;
					msgr=0;
					$('#msgdisplayin').html('').css('top','0px');
					addloading();
					getmsg(function(){showmsg();getmsg(function(){setting=false});});
				}
			});
		}
		else
			alertMsg("請輸入留言",'','normal');
	}
	else if(!canaddmsg)
			alertMsg("討論區暫不開放",'','normal');
		
}

function othervidenter(vid){
	$('#'+vid).css("background","rgba(0,0,0,0)");
}

function othervidleave(vid){
	$('#'+vid).css("background","rgba(0,0,0,0.75)")
}

function changestar(){
	$('#msgsubmit').attr('src',bUrl+"/file/img/video/submitstar.png");
}

function changegray(){
	$('#msgsubmit').attr('src',bUrl+"/file/img/video/submitgray.png");
}

function changenormal(){
	$('#msgsubmit').attr('src',bUrl+"/file/img/video/submit.png");
}

function morestar(){
	$('#moremsgimg').attr('src',bUrl+"/file/img/video/moremsgon.png");
}

function morenormal(){
	$('#moremsgimg').attr('src',bUrl+"/file/img/video/moremsg.png");
}

function moregray(){
	$('#moremsgimg').attr('src',bUrl+"/file/img/video/moremsgclick.png");
}

function tohome(uid){
	window.location=bUrl+'/profile/index/'+uid+'.html';
}
function comming(vid){
	if(!setting){
		vidnow=vid;
		canaddmsg=false;
		$("#viddisplayin").html('<img src='+bUrl+'/file/img/video/'+vid+'.jpg>');
		$('#msgdisplayin').html('');
		$('#msgdisplay').children('#scrollbar').remove();
		$('#vidinfoview').html('');
		$('#vidinfotitle').html('');
		$('#vidtalk').html('');
	}
}