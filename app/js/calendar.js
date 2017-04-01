(function($){
    $.calendar = function(){

      $('.eventContent').tooltip('hide') ;
      $("#calendar_leftarrow").css("display","none") ;
      
      var y =$('#bottomwords').position().left ;
      var frameWidth = $('#datecontent').width() ;
      var lengthNumber= new Array() ; 
      var leftlengthJS= new Array() ;
      var widthlengthJS= new Array() ;
      var rightlengthJS= new Array() ;//
      var contrast=new Array() ;//
      var wordsleft=new Array() ;

      var timestampStandard = Date.parse(new Date("Aug 04,2013"))/1000 ;//獲取時間戳(到秒數)
      var timestamp = Date.parse(new Date())/1000 ;
      // var timestamp = Date.parse(new Date("Sep 10,2013"))/1000 ;
      //for test測試用------------------------>

      var moveNumber = Math.floor((timestamp-timestampStandard)/(86400*7)) ;

      ////////////////讓頁面在一開始載入就可以自己跑動//////////////////
      window.onload=overlay;
      function overlay(){
        for(m=0;m<moveNumber;m++){
          document.getElementById('calendar_rightarrow').click();
        }
      }
      //////////////////////////////////////////////////////////////////


      $(document).ready(function(){
      // console.log('123');
      // console.dir($("#eventDisplay").children().children());
        $("#eventDisplay").children().children().each(function(){
          $(this).click(function(){
            if($(this).attr('id')!="number3" && $(this).attr('id')!="number8")
            // console.log($(this).attr('id'));
            select($(this).attr('filename'),$(this).attr('document'));
          });
        });

        $("#resentThing").children().each(function(){
          $(this).click(function(){
            if($(this).attr('id')!="num3" && $(this).attr('id')!="num8");
            select($(this).attr('filename'),$(this).attr('document'));
          });
        });

      });

      $(".divEventContent").hover(function(){
          $(this).css("background-color","#F8FF78")},
        function(){
          $(this).css("background-color","#F5FF3C")
        }) ;
    

      $("#number3").click(function(){  
          window.open("http://dorm.is.ncu.edu.tw/DormSys/main/index.jsp","mywindow");  
      });  
      $("#number8").click(function(){  
          window.open("https://course.ncu.edu.tw/Course/main/news/announce","mywindow");  
      });  




      for( n=0 ; n<17 ; n++ ){
        leftlengthJS[n] = $('#divNumber'+n).css("marginLeft").replace("px", "");//
        widthlengthJS[n] = $('#divNumber'+n).width();//
        rightlengthJS[n] = leftlengthJS[n] + widthlengthJS[n] ;//
        lengthNumber[n] = Math.floor((widthlengthJS[n] + leftlengthJS[n]%frameWidth) / frameWidth ) ;//
        contrast[n]=0 ;
        wordsleft[n]=0 ;
      }

      disappear (y) ;

      $("#calendar_leftarrow").click(function(){//讓物件按箭頭移動
          y+=frameWidth,
          $("#bottomwords").animate({left:y+'px'});
          disappear (y) ;
          for( n=0 ; n<17 ; n++ ){
            //去判斷有幾個星期  && 最後一段大於一天
            if( lengthNumber[n]!=0 && (widthlengthJS[n] + leftlengthJS[n]%frameWidth)%frameWidth>61 ){
              textSlideLeft(n) ;  
            }
          }
        }) ;

      $("#calendar_rightarrow").click(function(){//讓物件按箭頭移動
          y-=frameWidth,
          $("#bottomwords").animate({left:y+'px'}); 
          disappear (y);

          
          for( n=0 ; n<17 ; n++ ){
            //去判斷有幾個星期  && 最後一段大於一天
            if( lengthNumber[n]!=0 && (widthlengthJS[n] + leftlengthJS[n]%frameWidth)%frameWidth>61 ){
              textSlideRight(n) ;
            }
          }
        }) ;

      function disappear (y){
        if(y>=0){
          $("#calendar_leftarrow").css("display","none") ;
        }
        else if( y<-0&&y>(-frameWidth*25) ){
          $("#calendar_leftarrow").css("display","") ;
          $("#calendar_rightarrow").css("display","") ;
        }
        else if( y<=(-frameWidth*25) ){
          $("#calendar_rightarrow").css("display","none") ;
        }
      }

      function textSlideLeft(n){
        contrast[n]-- ;
        if( ((-y)+frameWidth)>leftlengthJS[n] ){//
           if( contrast[n]==0 ){
             wordsleft[n]=0 ;
             $("#number"+n).animate({marginLeft:(wordsleft[n])+'px'}); 
           }

          else if( contrast[n]<lengthNumber[n] ){//
            wordsleft[n]=wordsleft[n]-frameWidth ;
            $("#number"+n).animate({marginLeft:(wordsleft[n])+'px'});
          }
                          
        }
        if( ((-y)+frameWidth)<leftlengthJS[n] ){
          contrast[n]=0 ;
        }
      }

      function textSlideRight(n){

        if( (-y)>leftlengthJS[n] ){//
          if( contrast[n]==0 ){
            wordsleft[n]=frameWidth-leftlengthJS[n]%frameWidth ;
            $("#number"+n).animate({marginLeft:(wordsleft[n])+'px'}); 
          }

          else if( contrast[n]<lengthNumber[n] ){//
            wordsleft[n]=wordsleft[n]+frameWidth ;
            $("#number"+n).animate({marginLeft:(wordsleft[n])+'px'});
          }
          contrast[n]++ ;
                
        }

        if( ( (-y)<leftlengthJS[n] ) ){
          contrast[n]=0 ;
        }
      }

      function select(receiptor,category){
        jQuery.ajax({'success':function(data){
          var hi = $('<div id="dataHi"></div>').css({
            background: '#D3FEFF',
            top: '0px',
            margin: '0 auto',
            position: 'absolute',
            width: '100%'
          }).html(data);
          var hi2 = $('<div id="hi2"></div>').css({
            height: "100%",
            overflow: "hidden"
          }).append(hi);
          console.dir(hi2);
          $.jumpWindow(hi2);
          $.bar($('#hi2'));
        },
          'type': 'GET',
          'url': UrlData ,
          'data' : { 'receipt' : receiptor , 'category' : category } ,
          'cache':false,
      });
    }





    }
})(jQuery);

(function($)
{
    $(document).ready(function()
    {
        $.calendar() ;
    });
})(jQuery);