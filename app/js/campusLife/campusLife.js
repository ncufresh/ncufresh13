(function(b){b.life=function(f){function m(a){b("#flip"+a).click(function(){d!=a||c?0!=d||c?c||(c=!0,b("#mid_slide").slideUp("fast",function(){k(a,"nothing");l(a);b("#b"+d).slideUp("fast",function(){document.getElementById("set"+d).src=flip[d];b("#b"+a).slideDown("fast",function(){document.getElementById("set"+a).src=flipSet[a];b("#mid_slide").slideDown("slow",function(){d=a;c=!1;b.bar(b("#bodyscroll"));b.bar(b("#contentsBar"),!0)})})})})):(k(a,"nothing"),l(a),c=!0,b("#b"+a).slideDown("fast",function(){document.getElementById("set"+
a).src=flipSet[a];b("#mid_slide").slideDown("slow",function(){d=a;c=!1;b.bar(b("#bodyscroll"));b.bar(b("#contentsBar"),!0)})})):(c=!0,b("#mid_slide").slideUp("fast",function(){b("#b"+d).slideUp("fast",function(){k(a,"nothing");document.getElementById("set"+d).src=flip[d];d=0;c=!1;b.bar(b("#bodyscroll"))})}))})}function l(a){switch(a){case 1:a="_ncuBook";break;case 2:a="_ncuEat";break;case 3:a="_ncuNeed";break;case 4:a="_bike";break;case 5:a="_outMovie";break;case 6:a="_ncuHealth"}jQuery.ajax({success:function(a){b("#contents").html(a)},
data:{select:a},url:motionBody,cache:!1}).done(function(){b.bar(b("#contentsBar"),!0)})}function k(a,b){for(var d,c=0,f=1;10>f;f++)d="b"+a+"_"+f,null!=d.match(b)&&(c=f);0==e?(document.getElementById("b"+a+"_1").src=btnSet[a][1],e=a,g=1,h="b"+a+"_1"):a==e&&0==c?(document.getElementById(h).src=btnImg[e][g],e=0,g=c,h=""):a==e&&c!=g?(document.getElementById(h).src=btnImg[e][g],document.getElementById(b).src=btnSet[a][c],e=a,g=c,h=b):a!=e&&(document.getElementById(h).src=btnImg[e][g],document.getElementById("b"+
a+"_1").src=btnSet[a][1],e=a,g=1,h="b"+a+"_1")}var d=0,c=!1,g=0,h="nothing",e=0;b(".button").click(function(){choose=b(this).attr("id");img=b(this).children().attr("id");l(choose);k(d,img)});for(f=0;6>f;f++)m(f+1)}})(jQuery);(function(b){b(document).ready(function(){b.life()})})(jQuery);