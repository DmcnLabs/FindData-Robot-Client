
function getbyid(id) {
	if (document.getElementById) {
		return document.getElementById(id);
	} else if (document.all) {
		return document.all[id];
	} else if (document.layers) {
		return document.layers[id];
	} else {
		return null;
	}
}

function $(id) {
	return document.getElementById(id);
}

function checkValue(obj){
	document.getElementById("bank_type_value").value = obj.value;
}

var isIE = navigator.userAgent.toLowerCase().indexOf('ie');
var userAgent = navigator.userAgent.toLowerCase();
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);
var is_safari = (userAgent.indexOf('webkit') != -1 || userAgent.indexOf('safari') != -1);

function getTipDiv(e) {
	if(getbyid("xspace-tipDiv")) {
		divElement = getbyid("xspace-tipDiv");
	} else {
		var divElement = document.createElement("DIV");
		divElement.id = "xspace-tipDiv";
		document.body.appendChild(divElement);
	}
	divElement.className = "xspace-ajaxdiv";
	divElement.style.cssText = "width:400px;";
		
	var offX = 4;
	var offY = 4;
	var width = 0;
	var height = 0;
	var scrollX = 0;
	var scrollY = 0;  
	var x = 0;
	var y = 0;
		
	if (window.innerWidth) width = window.innerWidth - 18;
	else if (document.documentElement && document.documentElement.clientWidth) 
		width = document.documentElement.clientWidth;
	else if (document.body && document.body.clientWidth) 
		width = document.body.clientWidth;
		
	
	if (window.innerHeight) height = window.innerHeight - 18;
	else if (document.documentElement && document.documentElement.clientHeight) 
		height = document.documentElement.clientHeight;
	else if (document.body && document.body.clientHeight) 
		height = document.body.clientHeight;
	

	if (typeof window.pageXOffset == "number") scrollX = window.pageXOffset;
	else if (document.documentElement && document.documentElement.scrollLeft)
		scrollX = document.documentElement.scrollLeft;
	else if (document.body && document.body.scrollLeft) 
		scrollX = document.body.scrollLeft; 
	else if (window.scrollX) scrollX = window.scrollX;
				
	  
	if (typeof window.pageYOffset == "number") scrollY = window.pageYOffset;
	else if (document.documentElement && document.documentElement.scrollTop)
		scrollY = document.documentElement.scrollTop;
	else if (document.body && document.body.scrollTop) 
		scrollY = document.body.scrollTop; 
	else if (window.scrollY) scrollY = window.scrollY;
		
	x=e.pageX?e.pageX:e.clientX+scrollX;
	y=e.pageY?e.pageY:e.clientY+scrollY;

	if(x+divElement.offsetWidth+offX>width+scrollX){
		x=x-divElement.offsetWidth-offX;
		if(x<0)x=0;
	}else x=x+offX;
	if(y+divElement.offsetHeight+offY>height+scrollY){
		y=y-divElement.offsetHeight-offY;
		if(y<scrollY)y=height+scrollY-divElement.offsetHeight;
	}else y=y+offY;

	divElement.style.left = x+"px";
	divElement.style.top = y+"px";
	
}

function tagshow(e, tagname) {

	getTipDiv(e);
	var x = new Ajax('XML', 'statusid');
		
	x.get(siteUrl+'/batch.tagshow.php?tagname='+tagname, function(s){
		divElement = getbyid("xspace-tipDiv");
		divElement.innerHTML = s;
	});
}

function joinfriend(uid) {
	var x = new Ajax('XML', 'statusid');
		
	x.get(siteUrl+'/batch.common.php?action=joinfriend&uid='+uid, function(s){
		alert(s);
	});
}

function deletetrack(itemid) {
	var x = new Ajax('XML', 'statusid');

	x.get(siteUrl+'/batch.track.php?action=delete&itemid='+itemid, function(s){
		alert(s);
	});
}

function taghide() {
	var tip = getbyid("xspace-tipDiv");
	tip.style.display = 'none';
}

function searchtxt(id) {
	var searchval = document.getElementById(id).value;
	if(searchval == '??????' || searchval == '??????' || searchval == '??????') {
		document.getElementById(id).value = '';
	}
}

function addFirstTag() {
	var lists=new Array;
	lists=document.getElementsByTagName('ul');
	for(i=0;i<lists.length;i++){
		lists[i].firstChild.className+=' first-child';
	}
}

function setTab(area,id) {
	var tabArea=document.getElementById(area);

	var contents=tabArea.childNodes;
	for(i=0; i<contents.length; i++) {
		if(contents[i].className=='tabcontent'){contents[i].style.display='none';}
	}
	document.getElementById(id).style.display='';

	var tabs=document.getElementById(area+'tabs').getElementsByTagName('a');
	for(i=0; i<tabs.length; i++) { tabs[i].className='tab'; }
	document.getElementById(id+'tab').className='tab curtab';
	document.getElementById(id+'tab').blur();
}

function ColExpAllIntro(listid,obj) {
	var ctrlText = obj;
	var list = getbyid(listid);
	if(list.className == 'cleanlist') {
		list.className = 'messagelist';
		ctrlText.innerHTML = '???????????????';
		ctrlText.className = 'more minus';
	}else{
		list.className = 'cleanlist';
		ctrlText.innerHTML = '?????????????????????';
		ctrlText.className = 'more';
	}
}

function OpenWindow(url, winName, width, height) {
	xposition=0; yposition=0;
	if ((parseInt(navigator.appVersion) >= 4 )) {
		xposition = (screen.width - width) / 2;
		yposition = (screen.height - height) / 2;
	}
	theproperty= "width=" + width + ","
	+ "height=" + height + ","
	+ "location=0,"
	+ "menubar=0,"
	+ "resizable=1,"
	+ "scrollbars=1,"
	+ "status=0,"
	+ "titlebar=0,"
	+ "toolbar=0,"
	+ "hotkeys=0,"
	+ "screenx=" + xposition + "," //????????????Netscape
	+ "screeny=" + yposition + "," //????????????Netscape
	+ "left=" + xposition + "," //IE
	+ "top=" + yposition; //IE 
	window.open(url, winName, theproperty);
}

function joinfavorite(itemid) {
	var x = new Ajax('XML', 'statusid');
	x.get(siteUrl + '/batch.common.php?action=joinfavorite&itemid='+itemid, function(s) {
		alert(s);
	});
}

function report(itemid) {
	var x = new Ajax('XML', 'statusid');
	x.get(siteUrl + '/batch.common.php?action=report&itemid='+itemid, function(s) {
		alert(s);
	});
}


function getMsg() {
	if (GetCookie('readMsg')!='1') {
		var msgDiv = document.createElement('div');
		msgDiv.id = 'xspace-sitemsg';
		msgDiv.innerHTML = "<h6><span onclick='closeMsg();' class='xspace-close'>??????</span>??????:</h6><div>"+siteMsg+"<p class='xspace-more'><a href='"+siteUrl+"/index.php?action/announcement' target='_blank'>MORE</a></p></div>";
		document.body.insertBefore(msgDiv,document.body.firstChild);
		
		showMsg();
	}
}
function floatMsg() {
	window.onscroll = function() {
		document.getElementById('xspace-sitemsg').style.bottom = '10px';
		document.getElementById('xspace-sitemsg').style.background = '#EEF0F6';
	}
}
function showMsg() {
	var vh = document.getElementById('xspace-sitemsg').style.bottom;
	if (vh=='') {vh='-180px'}
	var vhLen = vh.length-2;
	var vhNum = parseInt(vh.substring(0,vhLen));
	
	if (vhNum<10) {
		document.getElementById('xspace-sitemsg').style.bottom = (vhNum+5)+'px';
		showvotetime = setTimeout("showMsg()",1);
	} else {
		floatMsg();
	}
}
function closeMsg() {
	document.getElementById('xspace-sitemsg').style.display = 'none';
	CreatCookie('readMsg','1');
}


/*Cookie??????*/
function CreatCookie(sName,sValue){
	var expires = function(){ //Cookie????????????
		var mydate = new Date();
		mydate.setTime(mydate.getTime + 3*30*24*60*60*1000);
		return mydate.toGMTString();
	}
	document.cookie = sName + "=" + sValue + ";expires=" + expires;
}
function GetCookieVal(offset) {//??????Cookie???????????????
	var endstr = document.cookie.indexOf (";", offset);
	if (endstr == -1)
	endstr = document.cookie.length;
	return unescape(document.cookie.substring(offset, endstr));
}
function GetCookie(sName) {//??????Cookie
	var arg = sName + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	while (i < clen)
	{
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg)
		return GetCookieVal (j);
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0) break;
	}
	return null;
}

function DelCookie(sName,sValue){ //??????Cookie
	document.cookie = sName + "=" + escape(sValue) + ";expires=Fri, 31 Dec 1999 23:59:59 GMT;";
}

//???????????????
function hidetoolbar() {
	window.parent.document.getElementById("toolbarframe").style.display="none";
}
function showtoolbar() {
	document.getElementById("toolbarframe").style.display = "block";
}
function mngLink(obj) {
	var wrap = window.parent.document.getElementById('wrap');
	if(wrap == null) {
		alert('????????????????????????????????????');
		return false;
	}
	if (wrap.className=='') {
		wrap.className = 'showmnglink';
		obj.innerHTML = '??????????????????';
	} else {
		wrap.className = '';
		obj.innerHTML = '??????????????????';
	}
}

//??????URL??????
function setCopy(_sTxt){
	if(navigator.userAgent.toLowerCase().indexOf('ie') > -1) {
		clipboardData.setData('Text',_sTxt);
		alert ("?????????"+_sTxt+"???\n?????????????????????????????????\n???????????????Ctrl+V?????????????????????????????????");
	} else {
		prompt("?????????????????????:",_sTxt); 
	}
}

//????????????
function addBookmark(site, url){
	if(navigator.userAgent.toLowerCase().indexOf('ie') > -1) {
		window.external.addFavorite(url,site)
	} else if (navigator.userAgent.toLowerCase().indexOf('opera') > -1) {
		alert ("?????????Ctrl+T????????????????????????");
	} else {
		alert ("?????????Ctrl+D????????????????????????");
	}
}

function findPosX(obj)
{
	var curleft = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
		curleft += obj.x;
	return curleft;
}
function findPosY(obj)
{
	var curtop = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (obj.y)
		curtop += obj.y;
	return curtop;
}

//??????????????????
var oldCateList;
function showHideCatList(action, id, menu, left, top, width) {
	var cateList = getbyid(menu);
	var t = 0;
	if(!left) left = 0;
	if(!top) top = 30;
	if (cateList != null) {
		var menuX = findPosX(getbyid(id))+left;
		var menuY = findPosY(getbyid(id))+top;
		
		if (action == 'show') {
			clearTimeout(document.t);
			if (oldCateList) {
				oldCateList.style.display = 'none';
			}
			cateList.style.display = 'block';
			if (!width) {
				cateList.style.width = '120px';
			} else {
				cateList.style.width = width+'px';
			}
			cateList.style.left = parseInt(menuX) + 'px';
			cateList.style.top = parseInt(menuY)+ 'px';
			oldCateList = cateList;
		} else if (action == 'hide') {
			document.t = setTimeout(function(){cateList.style.display = 'none'},500);
		}
	}
}

//??????
function rateHover(value) {
	getbyid('xspace-rates-star').className = 'xspace-rates'+value;
	getbyid('xspace-rates-tip').innerHTML = value;
}
function rateOut() {
	var rateValue = getbyid('xspace-rates-value').value;
	getbyid('xspace-rates-star').className = 'xspace-rates'+rateValue;
	getbyid('xspace-rates-tip').innerHTML = rateValue;
}
function setRate(value, itemid) {
	getbyid('xspace-phpframe').src = siteUrl+'/batch.comment.php?action=rate&rates='+value+'&itemid='+itemid;
}
function setRateXML(value, itemid) {
	getbyid('xspace-rates-value').value = value;
	if(value != '0') {
		var x = new Ajax('XML', 'statusid');
		x.get(siteUrl+'/batch.comment.php?action=rate&mode=xml&rates='+value+'&itemid='+itemid, function(s){
				alert(s);
		});
	}
}

//????????????
function setModelRate(name, itemid) {
	var x = new Ajax('XML', 'statusid');
	x.get(siteUrl+'/batch.comment.php?action=modelrate&name='+name+'&itemid='+itemid, function(s){
		if(s == 'rates_succeed') {
			getbyid('modelrate').innerHTML = parseInt(getbyid('modelrate').innerHTML) + 1;
		} else {
			alert(s);
		}
	});
}

function setSiteRate(value) {
	getbyid('rate-value').value = value;
	getbyid('ratesarea').className = 'rated'+value;
	getbyid('message').focus();
}

function adclick(id) {
	var x = new Ajax('XML', 'statusid');
	x.get(siteUrl + '/batch.common.php?action=adclick&id='+id, function(s){});
}
function display(id) {
	dobj = getbyid(id);
	if(dobj.style.display == 'none' || dobj.style.display == '') {
		dobj.style.display = 'block';
	} else {
		dobj.style.display = 'none';
	}
}


//??????????????????
function addMediaAction(div) {
	var thediv = getbyid(div);
	if(thediv) {
		var medias = thediv.getElementsByTagName('kbd');
		if(medias) {
			for (i=0;i<medias.length;i++) {
				if(medias[i].className=='showvideo' || medias[i].className=='showflash'|| medias[i].className=='showreal') {
					medias[i].onclick = function() {showmedia(this,400,400)};
				}
			}
		}
	}
}
function showmedia(Obj, mWidth, mHeight) {
	var mediaStr, smFile;
	if ( Obj.tagName.toLowerCase()=='a' ) { smFile = Obj.href; } else { smFile = Obj.title; }
	var smFileType = Obj.className.toLowerCase();

	switch(smFileType){
		case "showflash":
			mediaStr="<p style='text-align: right; margin: 0.3em 0; width: 520px;'>[<a href='"+smFile+"' target='_blank'>????????????</a>]</p><object codeBase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='520' height='390'><param name='movie' value='"+smFile+"'><param name='quality' value='high'><param name='AllowScriptAccess' value='never'><embed src='"+smFile+"' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='520' height='390'></embed></OBJECT>";
			break;
		case "showvideo":
			mediaStr="<object width='520' classid='CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6'><param name='url' value='"+smFile+"' /><embed width='520' type='application/x-mplayer2' src='"+smFile+"'></embed></object>";
			break;
		case "showreal":
			mediaStr="<object classid='clsid:CFCDAA03-8BE4-11CF-B84B-0020AFBBCCFA' width='520' height='390' id='RealMoviePlayer' border='0'><param name='_ExtentX' value='13229'><param name='_ExtentY' value='1058'><param name='controls' value='ImageWindow,controlpanel'><param name='AUTOSTART' value='1'><param name='CONSOLE' value='_master'><param name='SRC' value='"+smFile+"'><EMBED SRC='"+smFile+"' WIDTH='520' type='audio/x-pn-realaudio-plugin'  HEIGHT='390' NOJAVA='true' CONTROLS='ImageWindow,controlpanel' AUTOSTART='true' REGION='newsregion' CONSOLE='one'></EMBED></object>";
	}
	
	var mediaDiv = document.getElementById(escape(smFile.toLowerCase()));
	
	if (mediaDiv) {
		Obj.parentNode.removeChild(mediaDiv);
	} else {
		mediaDiv = document.createElement("div");
		mediaDiv.style.cssText = "text-align:center;text-indent:0"; 
		mediaDiv.id = escape(smFile.toLowerCase());
		mediaDiv.innerHTML = mediaStr;
		Obj.parentNode.insertBefore(mediaDiv,Obj.nextSibling);
	}
	return false;
}

//????????????????????????
function doZoom(size) {
	getbyid('blog_body').style.fontSize = size+'px';
}
//??????
function doPrint(){
	var csslink = document.getElementsByTagName('link');
	for (i=0; i<csslink.length; i++) {
		if (csslink[i].rel=='stylesheet') {
			csslink[i].disabled=true;
		}
	}

	printCSS = document.createElement("link");
	printCSS.id = 'printcss';
	printCSS.type = 'text/css';
	printCSS.rel = 'stylesheet';
	printCSS.href = siteUrl+'/css/print.css';
	
	var docHead = document.getElementsByTagName('head')[0];
	var mainCSS = csslink[0];
	docHead.insertBefore(printCSS,mainCSS);
	
	var articleTitle = document.getElementsByTagName('h1')[0];
	var cancelPrint = document.createElement("p");
	cancelPrint.id = 'cancelPrint';
	cancelPrint.style.textAlign = 'right';
	cancelPrint.innerHTML = "<a href='javascript:cancelPrint();' target='_self'>??????</a>&nbsp;&nbsp;<a href='javascript:window.print();' target='_self>??????</a>";
	getbyid('article').insertBefore(cancelPrint,articleTitle);
	
	window.print();
}
function cancelPrint() {
	if (printCSS) {
		document.getElementsByTagName('head')[0].removeChild(printCSS);
	}
	
	var csslink = document.getElementsByTagName('link');
	for (i=0; i<csslink.length; i++) {
		if (csslink[i].rel=='stylesheet') {
			csslink[i].disabled=false;
		}
	}

	if (getbyid('cancelPrint')) {
		getbyid('article').removeChild(getbyid('cancelPrint'));
	} 
}

//??????????????????????????????
function addImgLink(divID) {
	var msgarea = getbyid(divID);
	if(msgarea) {
		var imgs = msgarea.getElementsByTagName('img');
		for (i=0; i<imgs.length; i++) {
			if (imgs[i].parentNode.tagName.toLowerCase() != 'a') {
				imgs[i].title = '?????????????????????????????????';
				imgs[i].style.cursor = 'pointer';
				imgs[i].onclick = function() { window.open(this.src); }
			}
		}
	}
}

function ctlent(event,id) {
	var form = getbyid(id);
	if (event.ctrlKey && event.keyCode == 13) {
		form.submit();
	}
}

function getQuote(cid,itemid) {
	itemid = (typeof(itemid)=="undefined")?'':itemid; 
	var x = new Ajax('XML', 'statusid');
	x.get(siteUrl+'/batch.common.php?action=quote&cid='+cid, function(s){
		var aimobj = null;
		if(getbyid('message'+itemid) != null) {
			aimobj = document.getElementById('message'+itemid);
		}
		aimobj.value = s + "\n" + aimobj.value;
		aimobj.focus();
	});
}

function getModelQuote(name, cid) {

	var x = new  Ajax('XML', 'statusid');
	x.get(siteUrl+'/batch.common.php?action=modelquote&name='+name+'&cid='+cid, function(s){
		var revalue= s;
		var aimobj = null;
		if(getbyid('xspace-commentmsg') != null) {
			aimobj = getbyid('xspace-commentmsg');
		} else if(getbyid('messagecomm') != null) {
			aimobj = getbyid('messagecomm');
		}
		aimobj.value = revalue + "\n" + aimobj.value;
		aimobj.focus();
	});
}

function insertSmilies(smilieid) {
	var src = getbyid('smilie_' + smilieid).src;
	var code = getbyid('smilie_' + smilieid).alt;
	code += ' ';
	AddText(code);
}
function AddText(txt) {
	obj = getbyid('xspace-commentform').message;
	selection = document.selection;
	if(!obj.hasfocus) {
		obj.focus();
	}	
	if(typeof(obj.selectionStart) != 'undefined') {
		var opn = obj.selectionStart + 0;
		obj.value = obj.value.substr(0, obj.selectionStart) + txt + obj.value.substr(obj.selectionEnd);
	} else if(selection && selection.createRange) {
		var sel = selection.createRange();
		sel.text = txt;
		sel.moveStart('character', -strlen(txt));
	} else {
		obj.value += txt;
	}
}
function strlen(str) {
	return (str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length : str.length;
}

function joingroup(gid) {
	var x = new Ajax('XML', 'statusid');
		
	x.get(siteUrl+'/batch.common.php?action=joingroup&gid='+gid, function(s){
		alert(s);
	});
}

//?????????????????????
function showmanagemenu() {
	var obj = getbyid('xspace-managemenu');
	if(obj.style.display == 'none') {
		obj.style.display = '';
	} else {
		obj.style.display = 'none';
	}
	return false;
}

//????????????
function showelement(id) {
	var org = document.getElementById(id);
	if(org) {
		org.style.display='';
	}
}
function hideelement(id) {
	var org = document.getElementById(id);
	if(org) {
		org.style.display='none';
	}
}
function newseccode(id) {
	document.getElementById(id).src=siteUrl+'/do.php?action=seccode&rand='+Math.random(1);
}
/**
 * ??????
 */
function checkall(form, prefix, checkall, type) {

	var checkall = checkall ? checkall : 'chkall';
	var type = type ? type : 'name';
	
	for(var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		
		if(type == 'value' && e.type == "checkbox" && e.name != checkall) {
			if(e.name != checkall && (prefix && e.value == prefix)) {
				e.checked = form.elements[checkall].checked;
			}
		}else if(type == 'name' && e.type == "checkbox" && e.name != checkall) {
			if((!prefix || (prefix && e.name.match(prefix)))) {
				e.checked = form.elements[checkall].checked;
			}
		}
		
		
	}

}
function mjsop(radionvalue) {
	document.getElementById('divmnoop').style.display = "none";
	document.getElementById('divmsubscribe').style.display = "none";
	document.getElementById('divmcsubscribe').style.display = "none";
	if(radionvalue != 'mnoop') {
		document.getElementById('div'+radionvalue).style.display = "";
	}
}

function mcheckmail(){  
  var   sReg   =   /[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/; 
  var   obj    = getbyid('addsubmail');
  var   cobj   = getbyid('cancelsubmail');
  if (document.getElementById('divmsubscribe').style.display == "") {
	  if (obj.value == "") {
		  alert("?????????????????????!");
		  return   false;
	  }
	  if   ( ! sReg.test(obj.value)   )   {   
		  alert("Email?????????????????????????????????");   
		  return   false;   
	  }
  }
  if (document.getElementById('divmcsubscribe').style.display == "") {
	  if (cobj.value == "") {
		  alert("?????????????????????!");
		  return   false;
	  }
	  if   ( ! sReg.test(cobj.value)   )    {   
		  alert("Email?????????????????????????????????");   
		  return   false;   
	  }
  }    
  return   true;   
  }
/**
 * ??????????????????Flash?????????
 */
function _uFlash() {
	var f="-",n=navigator;
	if (n.plugins && n.plugins.length) {
		for (var ii=0;ii<n.plugins.length;ii++) {
			if (n.plugins[ii].name.indexOf('Shockwave Flash')!=-1) {
				f=n.plugins[ii].description.split('Shockwave Flash ')[1];
				break;
			}
		}
	} else if (window.ActiveXObject) {
		for (var ii=10;ii>=2;ii--) {
			try {
				var fl=eval("new ActiveXObject('ShockwaveFlash.ShockwaveFlash."+ii+"');");
				if (fl) { f=ii + '.0'; break; }
			} catch(e) {}
		}
	}
	//return f;
	if(f.indexOf("8")!=0 && f.indexOf("9")!=0) {
		alert("?????????????????????Flash8?????????????????????Flash???????????????????????????????????????");
	}
}

/**
 * ??????????????????????????????
 */
function getWindowSize() {
  var winWidth = 0, winHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    winWidth = window.innerWidth;
    winHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    winWidth = document.documentElement.clientWidth;
    winHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    winWidth = document.body.clientWidth;
    winHeight = document.body.clientHeight;
  }
  return {winWidth:winWidth,winHeight:winHeight}
}

function setdefaultpic() {

    if (getbyid("subjectpic")){
        var dev = getbyid("subjectpic").value;
        var picobj = document.getElementsByName("picid");
        var checked = false;
        for(var i=0;i<picobj.length;i++) {
            if(dev=="0") {
                picobj[i].checked = true;
                checked = true;
                break;
            } else if(picobj[i].value == dev) {
                picobj[i].checked = true;
                checked = true;
                break;
            }
        }
        if(!checked && typeof picobj[0] == "object") {
            picobj[0].checked = true;
        }
    }

}
/**
 * ???????????????
 */
function relatekw() {
	if(getbyid('tagname') != null) {
		var message = getEditorContents();
		message = message.substr(0, 500);
		message = message.replace(/&/ig, '', message);
		var x = new Ajax('XML', 'statusid');
		x.get(siteUrl+'/batch.common.php?action=relatekw&subjectenc=' + getbyid('subject').value + '&messageenc=' + message, function(s){
			if(s!=null) {
				getbyid('tagname').value = s;
			}
		});
	}
}

//?????????
function seccode() {
	var img = siteUrl+'/do.php?action=seccode&rand='+Math.random();
	document.writeln('<a href="javascript:updateseccode()" title="??????????????????????"><img id="img_seccode" style="vertical-align:middle;" src="'+img+'"></a>');
}
function updateseccode() {
	var img = siteUrl+'/do.php?action=seccode&rand='+Math.random();
	if(document.getElementById('img_seccode')) {
		document.getElementById('img_seccode').src = img;
	}
}

function trim(str) { 
	var re = /\s*(\S[^\0]*\S)\s*/; 
	re.exec(str); 
	return RegExp.$1; 
}

function in_array(needle, haystack) {
	if(typeof needle == 'string' || typeof needle == 'number') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}

function bookmarksite(title, url){

	if (document.all) {
		window.external.AddFavorite(url, title);
	} else if (window.sidebar) {
		window.sidebar.addPanel(title, url, "")
	}
}

function isEmail(str){
       var reg = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
       return reg.test(str);
}

function defaultchennel(form,channel) {
	
	var reg = eval("/show\\["+channel+"\\]/"); 
	for(var i = 0; i < form.elements.length; i++) {
		if(form.elements[i].name.match('show')) {
			if(form.elements[i].name.match(reg)) {
				if(form.elements[i].value == 1) {
					form.elements[i].checked = "checked";
				}
				form.elements[i].disabled = "disabled";
			} else {
				form.elements[i].disabled = false;
			}
		} 
	}
}

function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

function doane(event) {
	e = event ? event : window.event;
	if(is_ie) {
		e.returnValue = false;
		e.cancelBubble = true;
	} else if(e) {
		e.stopPropagation();
		e.preventDefault();
	}
}

//????????????
function show_click(id) {
	var ids = id.split('_');
	var id = ids[1];
	var clickid = ids[2];
	ajaxget(siteUrl+'/do.php?action=click&op=show&clickid='+clickid+'&id='+id, 'click_div');
}

function show_clicknum(id) {
	var ids = id.split('_');
	var id = ids[1];
	var clickid = ids[2];
	var title = ids[3] ? ids[3] : '';
	ajaxget(siteUrl+'/do.php?action=click&op=num&clickid='+clickid+'&id='+id, 'clicknum_'+id+'_'+clickid+(title==''?'':'_'+title));
}

function operatefloor(id) {
	var offset = 39;
	var num = document.getElementById('cid_'+id+'_floornum') ? parseInt(document.getElementById('cid_'+id+'_floornum').value) : 0;
	for(i=2, j=0; document.getElementById('cid_'+id+'_'+i)!=null || j==0; i++) {
		if(i > 5000) break;
		if(i > offset+1 && num && num-9 >= i) continue;
		if(document.getElementById('cid_'+id+'_'+i)) {
			document.getElementById('cid_'+id+'_'+i).className = 'old';
			j++;
		}
		if(document.getElementById('cid_'+id+'_'+i+'_title')) document.getElementById('cid_'+id+'_'+i+'_title').className = 'old_title';
		if(document.getElementById('cid_'+id+'_'+i+'_detail')) document.getElementById('cid_'+id+'_'+i+'_detail').className = 'detail';
	}
	if(document.getElementById('cid_'+id+'_elevator')) document.getElementById('cid_'+id+'_elevator').className = 'floor_op';
	document.getElementById('cid_'+id+'_tip').className = 'hideold';
	document.getElementById('cid_'+id+'_tip_detail').className = 'hideelement';
}
function elevator(id, type) {
	var offset = 39;
	var num = current = parseInt(document.getElementById('cid_'+id+'_elevatornum').value);
	var floornum = parseInt(document.getElementById('cid_'+id+'_floornum').value);
	var breturn = 1;
	for(i=0; i<offset; i++) {
		fnum = (type==1)?num+i+1:num%offset == 1 ? offset*(num/offset-1)-i : num-num%offset+1-i;
		if((type==1 && floornum-9 >= fnum) || (type==2 && num > offset+1 && fnum > 1)) {
			document.getElementById('cid_'+id+'_'+fnum).className = 'old';
			document.getElementById('cid_'+id+'_'+fnum+'_title').className = 'old_title';
			document.getElementById('cid_'+id+'_'+fnum+'_detail').className = 'detail';
			var current = fnum;
			breturn = 0;
		}
		if(breturn) return;

		fnum = num-i;
		if((type==1 && fnum > 1) || (type==2 && ((num%offset <= 1 && i < offset) || (num%offset > 1 && i < num%offset-1)))) {
			document.getElementById('cid_'+id+'_'+fnum).className = 'hideold';
			document.getElementById('cid_'+id+'_'+fnum+'_title').className = 'hideelement';
			document.getElementById('cid_'+id+'_'+fnum+'_detail').className = 'hideelement';
		}
	}

	document.getElementById('cid_'+id+'_elevatornum').value = (type==1)?current:current+offset-1;
	url = window.location.href.split('#');
	window.location.href = url[0]+'#cid_'+id;
}

function addupcid(id) {
	document.getElementById('upcid').value=id;
}

function submitcheck(itemid) {
	itemid = (typeof(itemid)=="undefined") ? '' : itemid ; 
	obj = document.getElementById('seccode'+itemid);
	if(obj && obj.value=='') {
		showelement('imgseccode'+itemid);
		obj.focus();
		return false;
	}
}

function zoomtextarea(objname, zoom) {
	zoomsize = zoom ? 10 : -10;
	obj = document.getElementById(objname);
	if(obj.rows + zoomsize > 0 && obj.cols + zoomsize * 3 > 0) {
		obj.rows += zoomsize;
		obj.cols += zoomsize * 3;
	}
}

//????????????
function getpostcate(id,itemid) {
	if(id != 0) {
		if(document.str == undefined) document.str = [];
		if(document.str[itemid+'i'+id]) {
			document.getElementById('cateselect').innerHTML = document.str[itemid+'i'+id];
		} else {
			var x = new Ajax('HTML', 'statusid');
		
			x.get(siteUrl+'/batch.postnews.php?ac=getcate&setid='+id+'&itemid='+itemid, function(s){
					document.getElementById('cateselect').innerHTML = s;
					document.str[itemid+'i'+id] = s;
			});
		}
	} else {
		document.getElementById('cateselect').innerHTML = '&nbsp;';
	}
}

function countcredit(obj, showid) {
	var len = obj.value;
	var showobj = document.getElementById(showid);
	showobj.innerHTML = len;
//	if(len < maxlimit) {
//		showobj.innerHTML = maxlimit - len;
//	} else {
//		obj.value = getStrbylen(obj.value, maxlimit);
//		showobj.innerHTML = "0";
//	}
}

//AJAX???DIV?????????
function showajaxdiv(url, width) {
	var x = new  Ajax('XML', 'statusid');
	x.get(url, function(s) {
		if(getbyid("xspace-ajax-div")) {
			var divElement = getbyid("xspace-ajax-div");
		} else {
			var divElement = document.createElement("DIV");
			divElement.id = "xspace-ajax-div";
			divElement.className = "xspace-ajaxdiv";
			document.body.appendChild(divElement);
		}
		divElement.style.cssText = "width:"+width+"px;";
		var userAgent = navigator.userAgent.toLowerCase();
		var is_opera = (userAgent.indexOf('opera') != -1);
		var clientHeight = scrollTop = 0; 
		if(is_opera) {
			clientHeight = document.body.clientHeight /2;
			scrollTop = document.body.scrollTop;
		} else {
			clientHeight = document.documentElement.clientHeight /2;
			scrollTop = document.documentElement.scrollTop;
		}
		divElement.innerHTML = s;
		divElement.style.left = (document.documentElement.clientWidth /2 +document.documentElement.scrollLeft - width/2)+"px";
		divElement.style.top = (clientHeight + scrollTop - divElement.clientHeight/2)+"px";
		
	});	
}
//AJAX DIV checkbox????????????JS 
function pushtab(){
	if ( document.getElementById("tr_pushfilter") && document.getElementById("tr_exeweek") && document.getElementById("tr_exehour"))	{
		document.getElementById("tr_pushfilter").style.display = (document.getElementById("tr_pushfilter").style.display == 'none')?'':'none';
		document.getElementById("tr_exeweek").style.display = (document.getElementById("tr_exeweek").style.display == 'none')?'':'none';
		document.getElementById("tr_exehour").style.display = (document.getElementById("tr_exehour").style.display == 'none')?'':'none';
	}
	if ( document.getElementById("mailpushtab").checked == true ){
		for(var i=0; i<7; i++){
			document.getElementById("exeweek"+i).disabled = false;
			document.getElementById("exehour"+i).disabled = false;
		}
		document.getElementById("pushfilter").disabled = false;
		document.getElementById("pushfilter").focus();
	}else {
		for(var i=0; i<7; i++){
			document.getElementById("exeweek"+i).disabled = true;
			document.getElementById("exehour"+i).disabled = true;
		}
		document.getElementById("pushfilter").disabled = true;
	}
}

//??????AJAX???DIV????????? 
function hidden_div(obj){
	if (document.getElementById(obj))	{
		document.getElementById(obj).style.display='none';
	}
}

//?????????
function showMask(){
	if(document.getElementById("tianyi-Mask"))
	{
		var oMask=document.getElementById("tianyi-Mask");
	}
	else
	{
		var oMask=document.createElement("DIV");
		oMask.id="tianyi-Mask";
		oMask.style.cssText = "position:absolute;left:0px;top:0px;background:#000;filter:Alpha(opacity=10);opacity:0.1;z-index:10000;";
		document.body.appendChild(oMask);
	}
	oMask.style.display = "block";
	oMask.style.width =   document.documentElement.scrollWidth + "px";
	oMask.style.height =   document.documentElement.scrollHeight + "px";
}
//for ????????????????????????????????????showajaxdiv()
function shownewajaxdiv(url,width,height,sty){
	var x = new  Ajax('XML', 'statusid');
	x.get(url, function(s) {
		if(s !='RET_NOLOGIN'){
			showMask();
			if(document.getElementById("xspace-ajax-div")) {
				var oDiv=document.getElementById("xspace-ajax-div");
			}
			else {
				var oDiv=document.createElement("DIV");
				oDiv.id="xspace-ajax-div";
				oDiv.className="xspace-ajaxdiv rounded3";
				document.body.appendChild(oDiv);
			}
			var st = window.pageYOffset || document.documentElement.scrollTop;
			var sl = window.pageXOffset || document.documentElement.scrollLeft;
			var bt = document.documentElement.clientHeight-height;
			var bl = document.documentElement.clientWidth-width;
			var top=(bt/2)+st-5;
			var left=(bl/2)+sl;
			var oDivStyle=oDiv.style;
			oDivStyle.display="";
			oDivStyle.width=width+"px";
			oDivStyle.top=top+"px";
			oDivStyle.left=left+"px";
			oDivStyle.position='absolute';
			oDivStyle.fontSize='12px';
			oDivStyle.zIndex='20001';
			if (sty==1)
			{
				oDivStyle.padding='5px';
				oDivStyle.border='0 none';
			}
			else
			{
				oDivStyle.padding='5px';
				oDivStyle.color='#fff';
				oDivStyle.border='0';
			}
			oDiv.innerHTML=s;
		}else {
			Msg('Please Login');
		}
	});
}
//for ??????image tips???
function newajaxdiv(obj,content,width,height,sty){
	if(document.getElementById("tianyi-"+obj)) {
		var oDiv=document.getElementById("tianyi-"+obj);
	} else {
		var oDiv=document.createElement("DIV");
		oDiv.id="tianyi-"+obj;
		oDiv.className="ajaxdiv rounded3";
		document.body.appendChild(oDiv);
	}
	var st = window.pageYOffset || document.documentElement.scrollTop;
	var sl = window.pageXOffset || document.documentElement.scrollLeft;
	var bt = document.documentElement.clientHeight-height;
	var bl = document.documentElement.clientWidth-width;
    var top=(bt/2)+st-5;
	var left=(bl/2)+sl;
	var oDivStyle=oDiv.style;
	if(document.getElementById("finndy-"+obj)) {
		top = 300;
		left = 250;
	}

	oDivStyle.display="";
	oDivStyle.top=top+"px";
	oDivStyle.left=left+"px";
	oDivStyle.position='absolute';
	oDivStyle.fontSize='12px';
	if (sty==1)
	{
		oDivStyle.width=width+"px";
		oDivStyle.padding='8px';
		oDivStyle.backgroundColor='#2b50d7';
		oDivStyle.color='#FFFFFF';
		oDivStyle.fontWeight='bold';
		//oDivStyle.border='1 solid #c0c7ca';
	}
	else
	{
		oDivStyle.width=width+"px";
		oDivStyle.padding='5px';
		oDivStyle.backgroundColor='#AAA';
		oDivStyle.color='#fff';
		oDivStyle.border='0';
	}
	oDivStyle.textAlign='center';
	oDiv.innerHTML=content;
}
//??????
function Msg(content){
	//showMask();
	newajaxdiv("msg",content,200,192,1);
	setTimeout("hidden_div('tianyi-msg');hidden_div('tianyi-Mask');",3000);
	
}

function showimg(url) {
	var wx=document.documentElement.clientWidth-40
	var hx=document.documentElement.clientHeight-40
	var img = new Image();
	img.src = url;
	newajaxdiv("imgline","?????????????????????",200,30);
	img.complete?ImgOK():img.onload=ImgOK;//img??????complete??????
	function ImgOK(){
		showMask();
		var width=img.width;
		var height=img.height;
		if(width>wx){height=(wx/width)*height;width=wx;}
		if(height>hx){width=(hx/height)*width;height=hx;}
		document.getElementById("tianyi-imgline").style.display='none';
		var pstr="<a href="+url+" target=\"_blank\"><img src=\"images/newwindow.gif\" title=\"????????????\" style=\"cursor:pointer;border:0px;position:absolute;right:15px;top:15px;\"></a>"
		newajaxdiv("img",pstr+"<img src="+url+" onclick=\"hidden_div('tianyi-Mask');hidden_div('tianyi-img');\" style=\"cursor:pointer;width:"+width+"px;height:"+height+"px;\" title=\"????????????\">",width,height,0);return;
	}
}
//??????????????????
function activeIndex(rid) {
	var x = new Ajax('XML', 'statusid');
	x.get(siteUrl + '/batch.common.php?action=activeIndex&rid='+rid, function(s) {
		if(s == 'RET_OK') {
			var indexing_btn = document.getElementById("indexing_btn"+rid);
			var activeindex_btn = document.getElementById("activeindex_btn"+rid);
			if (indexing_btn != null && activeindex_btn != null) {
				indexing_btn.style.display = "";
				activeindex_btn.style.display = "none";
				Msg('????????????????????????');
			}
		}else if(s == 'SOURCE_ALL_FREE_FULL') {
			Msg('??????????????????????????????????????????');
		}else if(s == 'SOURCE_USER_FREE_FULL') {
			Msg('??????????????????????????????????????????');
		}else if(s == 'SOURCE_USER_REVIEW_FULL') {
			Msg('??????????????????????????????????????????');
		}else if(s == 'RET_NOLOGIN') {
			Msg('????????????');
		}else {
			Msg('????????????');
		}
	});
}

//????????????
function undopush(sid) {
	var x = new Ajax('XML', 'statusid');
	x.get(siteUrl + '/batch.common.php?action=undopush&sid='+sid, function(s) {
		if(s =='RET_OK') {
			var pushbtn = document.getElementById("push_btn"+sid);
			var unpushbtn = document.getElementById("unpush_btn"+sid);
			//pushbtn.className = pushbtn.className.replace(/seabtn/g, "undobtn");//??????js??????class????????????????????????
			//pushbtn.innerHTML = "'.$blang['push_undo'].'";
			if (pushbtn != null) {
				pushbtn.style.display = "";
			}
			if (unpushbtn != null) {
				unpushbtn.style.display = "none";
			}
			var mypush = document.getElementById("mysourcepush");
			var objsid = document.getElementById("sid"+sid);
			if (mypush != null && objsid != null) { 
				//???????????????????????????s???'RET_OK'????????????alert(s)??????
				mypush.removeChild(objsid);//objsid???sid
			}
		}else {
			//alert(s);
			Msg('????????????');
		}
	});
}



//???????????????????????????????????????
function changeImg(objImg)
 {
     //var most = 680; //??????????????????
	 var most = document.getElementById("rightbox").offsetWidth - 50; //???????????????????????????PC+WAP
     if(objImg.width > most)
     {
         var scaling = 1-(objImg.width-most)/objImg.width;   
         //??????????????????
         objImg.width = objImg.width*scaling;
         objImg.height = objImg.height;          //img???????????????????????????????????????????????????
         //objImg.height = objImg.height*scaling;    //img?????????????????????????????????????????????
     }

}

//AJAX????????????????????? 
function getlastcomment(itemid, result) {//refer to: function register(..)
	if(result) {//????????????s???<ajaxok>
		var x = new Ajax('XML', 'statusid');
		x.get(siteUrl + '/batch.common.php?action=getlastcomment&itemid=' + itemid, function(s) {
			if (s != ''){
				//????????????????????????????????????
				var commbox = document.getElementById("commlist" + itemid);
				commbox.innerHTML += s;
				document.getElementById('message'+itemid).value = '';
				document.getElementById('replynum'+itemid).innerHTML = parseInt(document.getElementById('replynum'+itemid).innerHTML) + 1;
			}
		});
		newseccode('imgseccode'+ itemid);
	} else {
		newseccode('imgseccode'+ itemid);
	}
}

//????????????AJAX
function sendemailcheck(obj){
    var x = new Ajax('XML', 'ajaxwaitid');//???statusid?????????ajaxwaitid??????get???loading???????????????ajaxpost??????loading??????????????????
    x.get(siteUrl + '/batch.common.php?action=sendemailcheck', function(s) {
        if (s == 'RET_OK') {
            var textstr = 'Check your email';
            //obj.innerHTML = textstr.fontcolor("#888888");
            obj.onclick = function() {
                return false;
            }
            obj.disabled = true;
            Msg('Please check your email');
        } else if(s == 'RET_EMAIL_IS_NULL') {
            Msg('Please set your email');
        } else {
            ;
        }
    });
}

//SMS????????????AJAX
function sendsmsrequest(objid){
    var reg = /^1\d{10}$/;
    if (!document.getElementById(objid).value) {
        document.getElementById(objid).focus();
        return 'RET_NULL';
    }
    if(!reg.test(document.getElementById(objid).value)) {
        Msg('Please set a valid number');
        return 'RET_NULL';
    }
    var x = new Ajax('XML', 'ajaxwaitid');
    x.get(siteUrl + '/batch.common.php?action=sendsmsrequest&cellnum=' + document.getElementById(objid).value, function (s) {
        if (s == 'RET_OK'){
            Msg('Please check your message');
            GetNumber();
        } else if (s == 'RET_INVALID_CELLNUM') {
            Msg('Invalid cell number');
        } else if (s == 'RET_REPEAT_CELLNUM') {
            Msg('Please change a cell number');
        } else if (s == 'RET_NULL') {
            ;
        } else {
            Msg('Fail');
        }
    });

}
//????????????AJAX
function sendwebsitecheck(obj,objid){
	//???????????????
	document.getElementById(objid).value = document.getElementById(objid).value.toLowerCase();
	if(getbyid(objid) != null) {
		if (!document.getElementById(objid).value) {
			document.getElementById(objid).focus();
			return null;
		}else{
			if (!IsURL(document.getElementById(objid).value)) {
				Msg('???????????????');
				return null;
			}
		}
	} 
	var x = new Ajax('XML', 'ajaxwaitid');//???statusid?????????ajaxwaitid??????get???loading???????????????ajaxpost??????loading??????????????????
	//urlencode??????site_register???????????????
	x.get(siteUrl + '/batch.common.php?action=sendwebsitecheck&url=' + (is_ie && document.charset == 'utf-8' ? encodeURIComponent(document.getElementById(objid).value) : document.getElementById(objid).value), function(s) {
		if (s == 'RET_OK') {
			var textstr = '????????????';
			obj.innerHTML = textstr.fontcolor("#35bb0c");
			obj.onclick = function() {
				return false;
			}
			Msg('??????????????????');
		} else if(s == 'RET_URL_IS_NULL') {
			Msg('???????????????');
		} else {
			Msg('??????????????????');
		}
	});
}


function displaybox(id) {
	dobj = document.getElementById(id);
	if (dobj != null)	{
		if(dobj.style.display == 'none') {
			dobj.style.display = '';
		} else {
			dobj.style.display = 'none';
		}
	}

}

function IsURL(str_url) {
        var strRegex = "^((https|http|ftp|rtsp|mms)?://)"
        + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp???user@
        + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP?????????URL- 199.194.52.184
        + "|" // ??????IP???DOMAIN????????????
        + "([0-9a-z_!~*'()-]+\.)*" // ??????- www.
        + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // ????????????
        + "[a-z]{2,6})" // first level domain- .com or .museum
        + "(:[0-9]{1,4})?" // ??????- :80
        + "((/?)|" // a slash isn't required if there is no file name
        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";
        var re=new RegExp(strRegex);
        //re.test()
        if (re.test(str_url)){
            return (true);
        }else{
            return (false);
        }
}
//js??????get??????
function getArgs(){
    var args = {};
    var match = null;
    var search = decodeURIComponent(location.search.substring(1));
    var reg = /(?:([^&]+)=([^&]+))/g;
    while((match = reg.exec(search))!==null){
        args[match[1]] = match[2];
    }
    return args;
}
//????????????Radio???
//radio_name: document.myform.radio_name
function changeFormRadio(radio_name,aValue) {     
	for(var i=0;i<radio_name.length;i++) {
		if(radio_name[i].value==aValue) {
			radio_name[i].checked=true; 
			break;  
		}
	}
}

//?????????????????????????????????????????????
//id????????????id???myvalue???????????????????????????
function insertAtCursor(id, myValue) {
	var el = document.getElementById(id);
    if(id == 'encode'){
        //update
        el.value = myValue;
    }else{
        //addto
        //IE support
        if (document.selection) {
            el.focus();
            sel = document.selection.createRange();
            sel.text = myValue;
        } else if (el.selectionStart || el.selectionStart == '0') {
            //MOZILLA/NETSCAPE support
            var startPos = el.selectionStart;
            var endPos = el.selectionEnd;
            el.value = el.value.substring(0, startPos) + myValue + el.value.substring(endPos, el.value.length);
        } else {
            el.value += myValue;
        }
    }
}

function doClick1(o){
    o.className="nav_current";
    var j;
    var id;
    var e;

    for(var i=1;i<=3;i++){
        id ="nav"+i;
        j = document.getElementById(id);
        e = document.getElementById("sub"+i);
        if(id != o.id){
            j.className="nav_link";
            e.style.display = "none";
        }else{
            e.style.display = "block";
        }
    }
}

//http://phpjs.org/functions/htmlspecialchars_decode/
//A JavaScript equivalent of PHP???s htmlspecialchars_decode
function htmlspecialchars_decode(string, quote_style) {
    //       discuss at: http://phpjs.org/functions/htmlspecialchars_decode/
    //      original by: Mirek Slugen
    //        example 1: htmlspecialchars_decode("<p>this -&gt; &quot;</p>", 'ENT_NOQUOTES');
    //        returns 1: '<p>this -> &quot;</p>'
    //        example 2: htmlspecialchars_decode("&amp;quot;");
    //        returns 2: '&quot;'

    var optTemp = 0,
        i = 0,
        noquotes = false;
    if (typeof quote_style === 'undefined') {
        quote_style = 2;
    }
    string = string.toString()
        .replace(/&lt;/g, '<')
        .replace(/&gt;/g, '>');
    var OPTS = {
        'ENT_NOQUOTES'          : 0,
        'ENT_HTML_QUOTE_SINGLE' : 1,
        'ENT_HTML_QUOTE_DOUBLE' : 2,
        'ENT_COMPAT'            : 2,
        'ENT_QUOTES'            : 3,
        'ENT_IGNORE'            : 4
    };
    if (quote_style === 0) {
        noquotes = true;
    }
    if (typeof quote_style !== 'number') {
        // Allow for a single string or an array of string flags
        quote_style = [].concat(quote_style);
        for (i = 0; i < quote_style.length; i++) {
            // Resolve string input to bitwise e.g. 'PATHINFO_EXTENSION' becomes 4
            if (OPTS[quote_style[i]] === 0) {
                noquotes = true;
            } else if (OPTS[quote_style[i]]) {
                optTemp = optTemp | OPTS[quote_style[i]];
            }
        }
        quote_style = optTemp;
    }
    if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
        string = string.replace(/&#0*39;/g, "'"); // PHP doesn't currently escape if more than one 0, but it should
        // string = string.replace(/&apos;|&#x0*27;/g, "'"); // This would also be useful here, but not a part of PHP
    }
    if (!noquotes) {
        string = string.replace(/&quot;/g, '"');
    }
    // Put this in last place to avoid escape being double-decoded
    string = string.replace(/&amp;/g, '&');

    return string;
}
