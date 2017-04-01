color_code='';

function edit(e_name){

    jQuery.ajax({
                            'type'     : 'GET',
                            'dataType' : 'JSON',
                            'error'    : function(){
                                alertMsg('發生錯誤，請稍後再試',"","error");
                            },
                            'success'  : function(data){
                                if(data.status=="success"){
                                    $("#son5").html(data.html);
                                    $.bar($("#majorclub_dialog"));
                                    for(var i=1;i<=data.picArr.length;i++){ // change_pic
                                        mouse("#pic"+i);
                                        var pic_index=i+1;
                                        $("#pic"+i).attr("pic",data.picArr[pic_index]).click(function() {
                                            $("#majorclub_pictures img").attr("src",bUrl + "/file/majorclub_pictures/"+e_name+"/"+$(this).attr("pic")); // change big picture
                                        });
                                    }

                                }else{
                                    alertMsg("發生錯誤，請稍後再試","","error");
                                }

                            },
                            'data':{'selectEntries': e_name},
                            'url': bUrl + '/majorClub/edit.html',
    });

}
function entries(e_name)
{
    jQuery.ajax({
        'complete': function(){
            
        },
        'success':function(data){
            var son5 = $('<div id="son5"></div>');
            son5.html(data.html).promise().done(function(){
                jumpWindow(son5);
                $.bar($("#majorclub_dialog"));
                $("#img_bg img").attr("src",bUrl+'/file/img/majorclub/'+e_name+'_bg.png');
                switch(data.catalog){
                    case '0':
                        color_code='#98A6FB';// blue
                        break;
                    case '1':
                        color_code='#BFFB97';// green
                        break;
                    case '2':
                        color_code='#D298FB';// purple
                        break;
                }
                $("#edit").click(function(){edit($(this).attr("e_name"));});
                $("#bg_color").css({backgroundColor: color_code });
                for(var i=1;i<=data.picArr.length;i++){ // change_pic
                    mouse("#pic"+i);
                    var pic_index=i+1;
                    $("#pic"+i).attr("pic",data.picArr[pic_index]).click(function() {
                        $("#majorclub_pictures img").attr("src",bUrl + "/file/majorclub_pictures/"+e_name+"/"+$(this).attr("pic")); // change big picture
                    });
                }
            });
            // $("#son5").empty();
        },
        'url': bUrl + '/majorClub/final.html',
        'dataType':'JSON',
        'type':'GET',
        'data':{'selectEntries': e_name},
        'cache':false,

        });
}
function showList(catalog)
{
        jQuery.ajax({
            'success':function(data){
                animate('son2',data,function(){
                    mouse(".list_button");
                    touch("#entries_subtitle img",$("#entries_subtitle img").attr('catalog'));
                    $(".list_button").click(function(){
                        entries($(this).attr('e_name'));
                    });
                    var pageNum = countPage($("div#majorclub_layer3_entry img").length);// count how many page
                    vecTest("#entry_go","#entry_back",660,"#majorclub_layer3_entry",pageNum,px_en);// the vector event
                    console.log('pageNum='+pageNum);
                    console.log($("div#majorclub_layer3_entry img ").length);
                    mouseUpDown("#entry_go","left");
                    mouseUpDown("#entry_back","right");
                    $('#son2_warpped').find('*').css({opacity:1});
                });
            },
            'url': bUrl + '/majorClub/entries.html' ,
            'data': {'catalog':catalog},
            'type': 'GET',
            'cache':false});
}

function showSecondCatalog(firstCatalog){
    jQuery.ajax({
        'success':function(data){
			$("#bodyscroll").unbind();
            animate('son1',data.html,function(){
                mouse(".second_button");
                touch("#second_subtitle img",$("#second_subtitle img").attr('firstCatalog'));
                // touch("#second_subtitle img",$("#second_subtitle img").attr.('firstCatalog'));
                $(".second_button").click(function(){
                    showList($(this).attr('cata'));
                    nClcPic("second_button",data.picArr);
                    clc("#"+$(this).attr("id"),$(this).attr("picname"));
                });
                var pageNum = countPage($("div#majorclub_layer2_quality_m img").length); // count how many page
                vecTest("#vector_go_m","#vector_back_m",654,"#majorclub_layer2_quality_m",pageNum,px_secondcatalog); // the vector event
                mouseUpDown("#vector_go_m","left");
                mouseUpDown("#vector_back_m","right");
                $('#son1_warpped').find('*').css({opacity:1});
                animateClose('son2');
            });
            
        },
        'dataType':'JSON',
        'url': bUrl + '/majorClub/catalog/'+firstCatalog+'.html' ,
        'cache':false
        });
};
function mouse(id){
    $(id).mouseover(function(){
        $(this).stop().animate({bottom:'8px'},150);
    });
    $(id).mouseout(function(){
        $(this).stop().animate({bottom:'0px'},150);
    });
}
$(document).ready(function()
    {
        mouse(".first_button");
        touch("#index_subtitle img","majorclub_intro");
        // $("#index_subtitle").hover(function(){$(this).attr({"src",bUrl+'/file/img/majorclub/majorclub_intro_touch.png'});});
        $("#stu").mouseover(function(){
            $(this).stop().animate({bottom:'-47px'},150);
        });
        $("#stu").mouseout(function(){
            $(this).stop().animate({bottom:'-55px'},150);
        });

        $("#m").click(function(){showSecondCatalog(0);clc(this,"m");notClc("#stu","stu");notClc("#c","c");});

        $("#stu").click(function(){showSecondCatalog(1);clc(this,"stu");notClc("#m","m");notClc("#c","c");});

        $("#c").click(function(){showSecondCatalog(2);clc(this,"c");notClc("#stu","stu");notClc("#m","m");});
    }
);
function touch(selector,name){
    $(selector).hover(function(){
            $(this).attr("src",bUrl+'/file/img/majorclub/'+name+'_touch.png');},
            function(){$(this).attr("src",bUrl+'/file/img/majorclub/'+name+'.png');});
}
function clc(id,name){
    $(id).attr("src", bUrl+'/file/img/majorclub/clc_'+name+'.png');
}
function notClc(id,name){
    $(id).attr("src", bUrl+'/file/img/majorclub/'+name+'.png');  
}
function nClcPic(className,arr) {
    var allElements = document.getElementsByClassName(className);
    for (var i=0; i<allElements.length; i++) {
        allElements[i].setAttribute('src', bUrl+'/file/img/majorclub/'+arr[i]+'.png');
    }
}
function mouseUpDown(id,name){
    $(id).mousedown(function(){$(this).attr("src", bUrl+'/file/img/majorclub/clc_'+name+'.png');});
    $(id).mouseup(function(){$(this).attr("src", bUrl+'/file/img/majorclub/'+name+'.png');});
}
px_secondcatalog=0;
px_en=0;

function vecTest(vector_go,vector_back,page_length,slider,pageNum,px){
    // $(vector_go).css({visibility:"hidden"});
    if(pageNum==0){
        $(vector_back).css({visibility:"hidden"});
    }
    
    console.log('limit'+(-pageNum*page_length));
    $(vector_go).click(function(){
        $(vector_back).css({visibility: "visible"}).fadeIn(300);
        if(px>=0){
            hide(vector_go);px=0;
        }else{
            px+=page_length;
            $(slider).animate({left: px+'px'});
            if(px>=0){hide(vector_go);px=0;}
        }
        console.log('c='+px);
    });
    $(vector_back).click(function(){
        $(vector_go).css({visibility: "visible"}).fadeIn(300);
        if(px<=(-pageNum*page_length)){
            hide(vector_back);px=(-pageNum*page_length);
        }else{
            px-=page_length;
            $(slider).animate({left: px+'px'});
            if(px<=(-pageNum*page_length)){hide(vector_back);px=(-pageNum*page_length);}
        }
        console.log('c='+px);
    });
}
function hide(vector){
    $(vector).fadeOut(200, function() {
        $(this).show().css({visibility: "hidden"});
    });
}
function countPage(img_num){
    if(img_num%3==0){
        var page = img_num/3;
        return page-1;
    }else{
        var page = Math.floor(img_num/3);
        return page;
    }
}

function jumpWindow(options)
{

    var box = $('<div id="divShow"></div>').css({
        top: '0px',
        margin: 'auto',
        position: 'relative',
        overflow: 'hidden',
        height: '97%',
        width: '70%'
    }).html(options).prepend('<div id="close"></div>');


    $("#back").html(box).promise().done(function() {
        $("#close").css({
            backgroundImage: 'url("' + bUrl + '/file/img/close_jumpwindows.png")',
            width: '30px',
            height: '30px',
            position: 'absolute',
            zIndex: '5',
            right: '0px',
            top: '7.5%',
            cursor: 'pointer'
        }).click(function() {
            jumpWindowClose();
        });

        $("#back").fadeIn('slow',function(){
        });
        box.css({
            width: parseInt(options.css('width').replace("px", "")) + parseInt(options.css('paddingLeft').replace("px", "")) + parseInt(options.css('paddingRight').replace("px", "")) +'px',
            height: options.css("height") + parseInt(options.css('paddingTop').replace("px", "")) + parseInt(options.css('paddingBottom').replace("px", "")) +'px'
        });
    });
    
}
/*
跳出視窗關閉
*/

function jumpWindowClose(options)
{
    $("#back").fadeOut('slow',function() {
        $("#back").empty();
    });
    
}