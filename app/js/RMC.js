(function(e){e.RMC=function(){function aa(a,b,d){for(l=ba;a<l;a++){var ka=b,la=d,e=Math.floor(360*Math.random()+1)*Math.PI/180;p[a]=N;s[a]=Array(2);var m=Math.floor(50*Math.random());if(1==ca)switch(Math.floor(10*Math.random())){case 0:w[a]="V";break;case 1:w[a]="\u5197";break;case 2:w[a]="\u5b89\u5b89";break;case 3:w[a]="GG";break;case 4:w[a]="\u715e\u6c23";break;case 5:w[a]="\u4e0d\u61c2\u4e00\u500b";break;case 6:w[a]="\u4e0d\u8981\u54ed";break;case 7:w[a]="\u795e\u96f7\u745f\u96f7\u5e0c";break;
case 8:w[a]="\u706b\u795eBWE";break;case 9:w[a]="\u54c8\u6bd4"}else w[a]=da;switch(m){case 0:c[a]="Randomize ";break;case 1:c[a]="\u5e25\u54e5\u7f8a\u76ae ";break;case 2:c[a]="\u8c6c\u982d\u75de\u5b50 ";break;case 3:c[a]="\u5718\u8cfc\u80a5\u7682 ";break;case 4:c[a]="\u6697\u5f71\u72c2\u5f92 ";break;case 5:c[a]="\u7121\u76e1\u9818\u57df ";break;case 6:c[a]="\u6e34\u671b\u7684\u611b ";break;case 7:c[a]="\u65cb\u8f49\u8c46\u6f3f ";break;case 8:c[a]="GreenXp ";break;case 9:c[a]="\u6d41\u7802\u4e4b\u5d50 ";
break;case 10:c[a]="\u963f\u6176\u8001\u54e5 ";break;case 11:c[a]="\u6cd5\u83f2\u7279 ";break;case 12:c[a]="\u9811\u76ae\u8c79\u7b11\u4f60 ";break;case 13:c[a]="\u5c31\u9019\u6a23\u72c2\u66b4 ";break;case 14:c[a]="\u9b06\u6563\u786c\u786c ";break;case 15:c[a]="\u7834\u97f3\u86cb\u86cb ";break;case 16:c[a]="\u96d9\u5c64\u80a5\u8089 ";break;case 17:c[a]="\u574e\u4f2f\u7279\u5927\u5e1d ";break;case 18:c[a]="\u666e\u5e0c\u91d1\u9b54\u738b ";break;case 19:c[a]="\u666e\u540c\u4f8d\u885b ";break;case 20:c[a]=
"\u666e\u6b50\u5c4e\u795e ";break;case 21:c[a]="\u5197\u5ef7 ";break;case 22:c[a]="\u5197\u4f73 ";break;case 23:c[a]="\u5197\u7da0 ";break;case 24:c[a]="\u5b82\u4f0a ";break;case 25:c[a]="\u5197\u660c ";break;case 26:c[a]="\u5197\u786c ";break;case 27:c[a]="\u5197\u50d5 ";break;case 28:c[a]="\u5197\u83c7 ";break;case 29:c[a]="\u5197Q ";break;case 30:c[a]="\u9ed1\u6697\u5967\u65af\u5361 ";break;case 31:c[a]="\u9b54\u5e7b\u4fee\u98fe\u8005 ";break;case 32:c[a]="\u66f8\u5377\u7684\u6028\u9748 ";break;
case 33:c[a]="\u7981\u5730\u5275\u9020\u8005 ";break;case 34:c[a]="\u9177\u70ab\u5317\u6975\u718a ";break;case 35:c[a]="\u5abd ";break;case 36:c[a]="\u6b50\u897f\u91cc\u65af ";break;case 37:c[a]="\u83f2\u5c3c\u514b\u65af ";break;case 38:c[a]="\u5c0f\u660c\u660c ";break;case 39:c[a]="\u660c\u660c\u660c ";break;case 40:c[a]="\u8ed2\u8c6a ";break;case 41:c[a]="\u6bc5\u7fd4 ";break;case 42:c[a]="\u96c5\u82b9 ";break;case 43:c[a]="\u5049\u54f2 ";break;case 44:c[a]="\u5c3b\u6fa4\u745e\u723e ";break;case 45:c[a]=
"\u7d66\u6211\u5011\u53e3\u5df4 ";break;case 46:c[a]="\u8f1d\u54e5OP ";break;case 47:c[a]="\u6e05\u6d41\u7f8a\u7f8a\u5de8\u4eba ";break;case 48:c[a]="\u5feb\u624b\u4f73 ";break;case 49:c[a]="\u5feb\u8173\u4f73 "}n[a]=-1;F[a]=za;ea[a]=ma[1];G[a]=na[1];H[a]=!1;E[a]=fa;s[a][0]=Aa;s[a][1]=Ba;O[a]=oa[1];B[a]=Ca;y[a]=Da;x[a]=1;f[a]=ka;g[a]=la;h[a]=e;k[a]=Ea;Fa(a,ka,la)}}function Fa(a,b,Oa){pa[a]=setInterval(function(){B[a]+=10;B[a]>=qa[x[a]]&&ra(a);for(var b=Math.floor(1E3*Math.random()+1),c=1E4,d=0,e=
0;e<parseInt(z);e++)L(a,I[e],J[e])<c&&(c=L(a,I[e],J[e]),d=e);L(a,t,u)<Ga?sa(a):a==A[A[a]]?(ga=!0,p[a]=N,b=T(a,f[A[a]],g[A[a]]),h[a]=b,b=(Math.floor(Math.random()*p[a])-p[a]/2)*Math.PI/180,h[a]+=b,L(a,f[A[a]],g[A[a]])>G[A[a]]?(b=Math.floor(Math.random()*1*C)-0.3*C/2,k[a]+=b,b=k[a]*Math.cos(h[a]),c=-k[a]*Math.sin(h[a]),f[a]+=b,g[a]+=c):(ga&&a==A[A[a]]&&(A[a]=-1,A[A[a]]=-1,l<Ha&&(ba=l+Ia,ca++,da=w[a],aa(l,f[a],g[a]))),ga=!1)):L(a,f[n[a]],g[n[a]])<Ja?Ka(a):c<La?(b=d,p[a]=N,c=T(a,I[b],J[b]),h[a]=c,c=(Math.floor(Math.random()*
p[a])-p[a]/2)*Math.PI/180,h[a]+=c,L(a,I[b],J[b])>U[b]?(b=Math.floor(Math.random()*1*C)-0.3*C/2,k[a]+=b,b=k[a]*Math.cos(h[a]),c=-k[a]*Math.sin(h[a]),f[a]+=b,g[a]+=c):(K[b]-=ta[x[a]],B[a]+=ta[x[a]],B[a]>=qa[x[a]]&&ra(a))):1E3>=b&&b>E[a]?(E[a]=fa,E[a]+=5,b=0==F[a]?Math.floor(Math.random()*2*C):Math.floor(Math.random()*0.7*C)-0.3*C/2,c=Math.floor(1E4*Math.random()+1),1E4>=c&&c>s[a][0]?(1<1E4-s[a][0]&&(s[a][0]+=1),k[a]+=b,b=k[a]*Math.cos(h[a]),c=-k[a]*Math.sin(h[a]),f[a]+=b,g[a]+=c):s[a][0]>=c&&c>s[a][1]?
(100<s[a][0]-s[a][1]&&(s[a][0]-=100),c=(Math.floor(Math.random()*p[a])-p[a]/2)*Math.PI/180,k[a]+=b,p[a]=N,h[a]+=c,b=k[a]*Math.cos(h[a]),c=-k[a]*Math.sin(h[a]),f[a]+=b,g[a]+=c):k[a]=0):E[a]>=b&&0<b&&(E[a]=fa,E[a]=0,sa(n[a]))},1E3/ha);setInterval(function(){m.clearRect(0,0,q,r);m.save();m.drawImage(ua,q/15,0,0.9*q,r);m.restore();for(var a=0;a<parseInt(z);a++)m.save(),m.translate(I[a],J[a]),m.rotate(-V[a]),m.drawImage(d[W[a]][2],-(X/2),-(X/2)),m.restore();for(a=0;a<l;a++)f[a]<P?(f[a]=P,p[a]=360):f[a]>
q-P&&(f[a]=q-P,p[a]=360),g[a]<Q?(g[a]=Q,p[a]=360):g[a]>r-Q&&(g[a]=r-Q,p[a]=360),0>k[a]?k[a]=0:k[a]>O[a]&&(k[a]=O[a]),m.save(),m.translate(f[a],g[a]),m.rotate(-h[a]),m.drawImage(d[x[a]][F[a]],-(X/2),-(X/2)),m.restore(),ia&&(m.save(),m.translate(f[a]-35,g[a]-85),m.fillStyle="#FF0000",m.font="20px Georgia",m.fillText(c[a]+"_"+w[a],10,50),m.restore());m.save();m.translate(t,u);m.drawImage(R,-80,-80);m.restore()},1E3/va);e("div").mousedown(function(){R.src=bUrl+D[M][1];f[a]+G[a]+Y>t&&(t>f[a]-G[a]-Y&&g[a]+
G[a]+Y>u&&u>g[a]-G[a]-Y)&&!H[a]&&(0<parseInt(y[a])&&(F[a]=0,y[a]-=Ma,H[a]=!0,console.log(F[a])),0>=parseInt(y[a])&&wa(a));setTimeout(function(){R.src=bUrl+D[M][0];xa()},100)})}function L(a,b,c){b-=f[a];a=-(c-g[a]);return Math.sqrt(b*b+a*a)}function T(a,b,c){b-=f[a];c=-(c-g[a]);var d=Math.sqrt(b*b+c*c);if(0==d)return h[a]+Math.PI;a=Math.acos(b/d);0>c&&(a*=-1);return a}function wa(a){ja(f[a],g[a],G[a]-10,h[a],B[a],x[a]);for(var b=0;b<l;b++)n[b]==a?n[b]=l-1:n[b]>a&&(n[b]-=1);for(b=a;b<l-1;b++)n[b]=n[b+
1],F[b]=F[b+1],H[b]=H[b+1],O[b]=O[b+1],x[b]=x[b+1],B[b]=B[b+1],y[b]=y[b+1],f[b]=f[b+1],g[b]=g[b+1],h[b]=h[b+1],k[b]=k[b+1],p[b]=p[b+1],c[b]=c[b+1],E[b]=E[b+1],s[b]=s[b+1];l--;f[l]=1E4;g[l]=1E4;clearInterval(pa[l])}function ja(a,b,c,d,e,f){I[z]=a;J[z]=b;U[z]=c;V[z]=d;K[z]=e;W[z]=f;z++}function xa(){for(var a=0;a<l;a++)F[a]=1,H[a]=!1}function ra(a){11!=k[a]&&(x[a]++,ea[a]=ma[x[a]],O[a]=oa[x[a]],G[a]=na[x[a]],y[a]+=400*x[a])}function ya(){if(1<l)for(var a=0;a<l;a++)for(;;){var b=Math.floor(Math.random()*
l);if(b!=a){A[a]=b;break}}}function Ka(a){p[a]=N;var b=T(a,f[n[a]],g[n[a]]);h[a]=b;b=(Math.floor(Math.random()*p[a])-p[a]/2)*Math.PI/180;h[a]+=b;if(L(a,f[n[a]],g[n[a]])>G[n[a]]){b=Math.floor(Math.random()*1*C)-0.3*C/2;k[a]+=b;var b=k[a]*Math.cos(h[a]),c=-k[a]*Math.sin(h[a]);f[a]+=b;g[a]+=c}else H[n[a]]||(H[n[a]]=!0,F[n[a]]=0,y[n[a]]-=ea[a],setTimeout(function(){xa()},400),0>=y[[n[a]]]&&wa(n[a]))}function sa(a){p[a]=N;var b=Math.floor(Math.random()*1*C)-0.3*C/2,c=T(a,t,u)+Math.PI;h[a]=c;c=(Math.floor(Math.random()*
p[a])-p[a]/2)*Math.PI/180;h[a]+=c;k[a]+=b;b=k[a]*Math.cos(h[a]);c=-k[a]*Math.sin(h[a]);f[a]+=b;g[a]+=c}var va=60,ha=15,q=0.7*e(window).width(),r=0.7*e(window).height();0.8*q<=r?r=0.8*q:q=1.25*r;1600<q&&(q=1600,r=1280);var P=0.1*q,Q=0.13*r,C=4,Y=20,Ma=2E3,Aa=500,Ba=10,fa=0,Ea=0,N=100,La=(q+r)/6,Ga=(q+r)/7,Ja=(q+r)/8,Da=1E3,Ca=5E3,za=1,Ia=5,ia=!1,ua=new Image;ua.src=bUrl+"/file/rmc/bg3.jpg";for(var z=0,K=[],I=[],J=[],V=[],U=[],W=[],ba=10,l=0,t=0,u=0,Z,Ha=150,ca=1,ga=!1,da="",c=[],w=[],A=[],n=[],G=[],
ea=[],H=[],O=[],x=[],B=[],y=[],f=[],g=[],h=[],k=[],p=[],E=[],s=[],pa=[],F=[],qa=[,4E4,8E4,16E4,32E4,64E4,128E4,256E4,512E4,1024E4,2048E4,1E19],na=[,50,50,50,50,50,50,50,50,50,50,50],oa=[,5,5,6,6,7,7,7,8,8,9,10],ma=[,200,300,400,500,800,1500,2E3,2500,3E3,4E3,6E3],ta=[,1E3,2E3,3E3,4E3,5E3,6E3,7E3,8E3,9E3,1E4,2E4],X=100,d=[],v=1;13>=v;v++)d[v]=Array(2),d[v][0]=new Image,d[v][1]=new Image,d[v][2]=new Image;d[1][0].src=bUrl+"/file/rmc/shockRoach1.png";d[2][0].src=bUrl+"/file/rmc/shockRoach2.png";d[3][0].src=
bUrl+"/file/rmc/shockRoach3.png";d[4][0].src=bUrl+"/file/rmc/shockRoach4.png";d[5][0].src=bUrl+"/file/rmc/shockRoach5.png";d[6][0].src=bUrl+"/file/rmc/shockRoach6.png";d[7][0].src=bUrl+"/file/rmc/shockRoach7.png";d[8][0].src=bUrl+"/file/rmc/shockRoach8.png";d[9][0].src=bUrl+"/file/rmc/shockRoach9.png";d[10][0].src=bUrl+"/file/rmc/shockRoach10.png";d[11][0].src=bUrl+"/file/rmc/shockRoach11.png";d[1][1].src=bUrl+"/file/rmc/cuteRoach1.png";d[2][1].src=bUrl+"/file/rmc/cuteRoach2.png";d[3][1].src=bUrl+
"/file/rmc/cuteRoach3.png";d[4][1].src=bUrl+"/file/rmc/cuteRoach4.png";d[5][1].src=bUrl+"/file/rmc/cuteRoach5.png";d[6][1].src=bUrl+"/file/rmc/cuteRoach6.png";d[7][1].src=bUrl+"/file/rmc/cuteRoach7.png";d[8][1].src=bUrl+"/file/rmc/cuteRoach8.png";d[9][1].src=bUrl+"/file/rmc/cuteRoach9.png";d[10][1].src=bUrl+"/file/rmc/cuteRoach10.png";d[11][1].src=bUrl+"/file/rmc/cuteRoach11.png";d[1][2].src=bUrl+"/file/rmc/bloodRoach1.png";d[2][2].src=bUrl+"/file/rmc/bloodRoach2.png";d[3][2].src=bUrl+"/file/rmc/bloodRoach3.png";
d[4][2].src=bUrl+"/file/rmc/bloodRoach4.png";d[5][2].src=bUrl+"/file/rmc/bloodRoach5.png";d[6][2].src=bUrl+"/file/rmc/bloodRoach6.png";d[7][2].src=bUrl+"/file/rmc/bloodRoach7.png";d[8][2].src=bUrl+"/file/rmc/bloodRoach8.png";d[9][2].src=bUrl+"/file/rmc/bloodRoach9.png";d[10][2].src=bUrl+"/file/rmc/bloodRoach10.png";d[11][2].src=bUrl+"/file/rmc/bloodRoach11.png";d[12][2].src=bUrl+"/file/rmc/cake.png";d[13][2].src=bUrl+"/file/rmc/banana.png";for(var M=1,R=new Image,D=Array(2),v=1;3>=v;v++)D[v]=Array(2);
D[1][0]="/file/rmc/bw1.gif";D[2][0]="/file/rmc/rw1.gif";D[3][0]="/file/rmc/gw1.gif";D[1][1]="/file/rmc/bw2.gif";D[2][1]="/file/rmc/rw2.gif";D[3][1]="/file/rmc/gw2.gif";R.src=bUrl+D[M][0];var S=e('<div ONDRAGSTART="window.event.returnValue=false" onSelectStart="event.returnValue=false" ONCONTEXTMENU="window.event.returnValue=false"></div>').css({overflow:"hidden",width:"100%",height:"100%",position:"fixed",background:"rgba(0,0,0,0.5)",left:"0px",top:"0px",textAlign:"center",zIndex:"20"}).appendTo("body").fadeIn(),
v=e('<div id="divUser"></div>').css({padding:"2%",top:"5%",margin:"auto",position:"relative",width:1.4*q+"px",height:r+"px",textAlign:"right"}).appendTo(S),Na=e('<div id="divShow"></div>').css({display:"inline-block",width:q+"px",height:r+"px"}).appendTo(v);e('<canvas width="'+q+'" height="'+0.95*r+'" id="canvas"></canvas>').css({cursor:"none"}).appendTo(Na);var m=document.getElementById("canvas").getContext("2d");e('<img src ="'+bUrl+'/file/rmc/bg1.png"></img>').css({cursor:"none",position:"relative",
left:"2%",top:"-105%",margin:"auto",width:"100%"}).appendTo(v);Z=e('<div id="divMarker"><br /></div>').css({overflow:"hidden",background:"rgba(0,0,0,0.5)",padding:"1%",textAlign:"left",position:"relative",left:"2%",top:"-70%",display:"none",height:"80%",width:"25%"}).appendTo(S);v=e('<div id="bar"></div>').css({overflow:"hidden",position:"relative",textAlign:"center",height:"100%",width:"100%"}).appendTo(Z);e('<div id="divCon"></div>').css({position:"absolute",top:"0px",padding:"1%",textAlign:"left",
height:"300px",width:"90%"}).appendTo(v);e.bar(e("#bar"));S.click(function(a){e(a.target).parents("#divShow")});e(document).keyup(function(a){79==a.keyCode&&("none"==e("#divMarker").css("display")?(ia=!0,Z=setInterval(function(){e("#divCon").empty();e("<table style=border: 'none';  width: '100%'; align='left' cellpadding='10' cellspacing='0' frame='void' rules='none'><tbody id = 'table'></table></table>").appendTo("#divCon");e("<tr><td><font color='red'>ID</font></td> <td><font color='red'>HP</font></td> <td><font color='red'>EXP</font></td></tr>").appendTo("#table");
for(var a=0;a<l;a++)e("<tr><td><font color='red'>"+c[a]+"_"+w[a]+"</font></td> <td><font color='red'>"+y[a]+"</font></td> <td><font color='red'>"+B[a]+"</font></td></tr>").appendTo("#table")},1E3/va),e("#divMarker").show()):(ia=!1,clearInterval(Z),e("#divMarker").hide()));27==a.keyCode||69==a.keyCode?(S.unbind(),S.fadeOut()):P<t&&(q-P>t&&Q<u&&r-Q>u)&&(81==a.keyCode&&ja(t,u,60,0,7500,12),87==a.keyCode&&ja(t,u,30,h[l-1],15E3,13),49==a.keyCode?M=1:50==a.keyCode?M=2:51==a.keyCode&&(M=3),R.src=bUrl+D[M][0],
82==a.keyCode&&10>l&&(ca++,ba=l+5,da="PlayerIsGod",aa(l,t,u)))});(function(){e("div").mousemove(function(a){t=a.pageX;u=a.pageY;0>t&&(t=0);0>u&&(u=0);t-=e("#divShow").offset().left;u-=e("#divShow").offset().top})})();setInterval(function(){for(var a=0;a<z;a++)K[a]-=5},100);setInterval(function(){for(var a=0;a<parseInt(z);a++)if(0>=K[a]){for(var b=a;b<z-1;b++)I[b]=I[b+1],J[b]=J[b+1],U[b]=U[b+1],V[b]=V[b+1],K[b]=K[b+1],W[b]=W[b+1];z--}},50);setInterval(function(){ya()},12E5/(2*ha));setInterval(function(){if(3<
l)for(var a=0;a<l;a++)for(;;){var b=Math.floor(Math.random()*l);if(b!=a){n[a]=b;break}}else 1<l&&ya()},18E5/(3*ha));aa(0,q/2,r/2)}})(jQuery);$.RMC();