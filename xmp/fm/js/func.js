var s = navigator.userAgent.toLowerCase();
 isIE = (s.indexOf('msie') != -1);
 isGecko = (s.indexOf('gecko') != -1);
 isSafari = (s.indexOf('safari') != -1);
 isOpera = (s.indexOf('opera') != -1);
 isKonqueror = (s.indexOf('konqueror') != -1);


function toDecimal(original) {
	temp = Math.round(original*100)/100;
	if((original * 100) % 100 == 0)
		return temp + '.00';
	if((original * 10) % 10 == 0)
		return temp + '0';
	return temp
}

function isInteger(s) {
    for (var i = 0; i < s.length; i++){
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function isNumeric(s) {
  if(!s.length) return true;
  if(!/^-*[0-9\.]+$/.test(s)) {
   		return false;
   }
   else {
		return true;
   }
}
function isValidEmail(emailStr) {
	if(emailStr.length== 0) {
		return true;
	}
	if(!/^\w+(['\.\-\+]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(emailStr))
		return false;
	return true;	
}
//'
function isValidPhone(phoneStr) {
	if(phoneStr.length== 0) {
		return true;
	}
	if(!/^[0-9\-\(\)]+$/.test(phoneStr))
		return false
	return true	
}
function isFloat(floatStr) {
	if(floatStr.length== 0) {
		return true;
	}
	if(!/^[0-9\.]+$/.test(floatStr))
		return false;
	return true;
}

function formatFloat(str,n) {
    var pos;
    if((pos=str.indexOf('.')) == -1) {
	str+='.';
	for(; n > 0; n--) str+='0';
        return str;
    }
    var t=str.substr(pos);
    if(t.length > n) return str.substr(0,pos+n+1);
    for(; n >= t.length; n--) str+='0';
    return str;

}


function inRange(value, min, max) {
	return value >= min && value <= max;
}


function trim(s) {
	if(typeof(s) == 'undefined')  
		return s;
	while (s.substring(0,1) == " ") {
		s = s.substring(1, s.length);
	}
	while (s.substring(s.length-1, s.length) == ' ') {
		s = s.substring(0,s.length-1);
	}

	return s;
}
function hex2dec(hex){
    return(parseInt(hex,16));
}

function dec2hex(dec){
    var hexDigit=new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
    return(hexDigit[dec>>4]+hexDigit[dec&15]);
}


/*------------------------------------*/
function setPage(n) {
    $('module_form').current_page.value = n-1;
    loadModule(1);
}

function setLimitDisplay(n) {
    if(!$('module_form').limit_display) return;
    $('module_form').limit_display.value = n;
    $('module_form').current_page.value = 0;
    limit_display = n;
    loadModule(1);
}

function selectAll() {
 for(var i=0; i < limit_display;i++) if($('list_mark['+i+']')) $('list_mark['+i+']').checked=true;
}
function unselectAll() {
 for(var i=0; i < limit_display;i++) if($('list_mark['+i+']')) $('list_mark['+i+']').checked=false;
}
function getChecked() {
 var a = new Array();
 for(var i=0,j=0; i < limit_display;i++) 
     if($('list_mark['+i+']') && $('list_mark['+i+']').checked) a[j++]=$('list_mark['+i+']').value;
 return a;
}

function searchModule(){
 $('module_form').current_page.value=0;
 loadModule(1);
}
function setFixPeriod(p) {
    if(p == '0') return;
    var d = new Date();
    var periodto,periodfrom;
    periodfrom=periodto=d.getTime();
    var day = d.getDay();
    var prevmonth = d.getMonth();
    if(day) day--; else day=6;
    if(prevmonth) prevmonth--; else prevmonth=11;
    var year = d.getFullYear();
    switch (p) {
	case '1': periodfrom-=2*Date.HOUR;  break;
	case '2': periodfrom-=11*Date.HOUR; break;
	case '3': d.setHours(0,0,0,0); periodfrom=d.getTime(); 
		  periodto=d.getTime()+Date.DAY-1000; break;
	case '4': d.setHours(0,0,0,0); periodfrom=d.getTime()-Date.DAY; 
		  periodto=d.getTime()-1000;break;
	case '5': d.setHours(0,0,0,0); periodfrom=d.getTime() - (2*Date.DAY); 
	          periodto=d.getTime()+Date.DAY-1000;break;
	case '6': d.setHours(0,0,0,0); periodfrom=d.getTime() - (day*Date.DAY); 
	          periodto=d.getTime()+Date.DAY-1000;break;
	case '7': d.setHours(0,0,0,0); periodto=d.getTime()+Date.DAY-1000;
		  d.setDate(1); periodfrom=d.getTime(); break;
	case '8': d.setDate(1); d.setHours(0,0,0,0); periodto=d.getTime()- 1000;
		  d.setMonth(prevmonth); 
		  if(prevmonth == 11) d.setYear(year-1);
		  periodfrom=d.getTime(); 
		  break;
	default: periodfrom-=3*Date.HOUR; break;
    }
    var dt= new Array;    
    dt[0] = new Date(periodfrom);
    dt[1] = new Date(periodto);
    return dt;
}    

function getQueryString(arr,str) {
	arr.compact();
	for (var i=0, s=''; i < arr.length; i++) {
	    s+='&'+str+'['+i+']='+encodeURIComponent(arr[i]);
	}
	return s;
}