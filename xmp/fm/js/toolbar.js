/*-------------------------------------------------------------------------
 *  Copyright (c) 2007 Nickolay Shestakov
 *
 *  This software is freely distributable under the terms of an 
 *  GNU General Public License version 2.
 *
 *--------------------------------------------------------------------------*/
_Toolbar = Class.create();
_Toolbar.prototype = {
    initialize : function(container, options) {
	this.container = container;
	this.items = new Object();
	this.setOptions(options);
	this.separator=this.options.imgdir+'/separator.gif';
	//if(!container) return;
    },
    setOptions: function(options) {
	this.options = {
	    imgdir	: 'images',
	    className	: null,
	    panelBg	: '#dddddd',
	    cellSize	: 19,
	    cellBg	: '#babcd1',
	    cellBorderBg: '#34548f'
	}
	Object.extend(this.options, options || {});
    
    },
    create: function(menu) {
	var div = document.createElement('div');
	$(this.container).appendChild(div);
	div.style.cssText="background-color: "+this.options.panelBg+";";
	var html='';
	//alert(this.options.className);
	var tblH=this.options.cellSize+5;
	if(this.options.className) 
    	    html="<table border=0 cellpadding=1 cellspacing=0 class='"+this.options.className+"' style='height: "+tblH+"px;'><tr>";
	else html="<table border=0 cellpadding=1 cellspacing=0 style='border: 0; font-size: 12px; font-family: verdana,sans; height: "+tblH+"px;'><tr >";
	var j,m;
	for (var i=0; i < menu.length ; i++) {
	  j=menu[i];      
	  if(j=='/') {
	    html+="<td style='width: 2px;background-color: "+this.options.panelBg+"; border: 1px solid "+this.options.panelBg+";'><img src='"+this.separator+"'></td>";
	    continue;
	  }
	  if(this.items[j]) {
	    m=this.items[j];
	    var ev = m[6] ? m[6] : 'onclick';
	    if(m[5]) html+="<td style='border: 1px solid "+this.options.panelBg+";background-color: "+this.options.panelBg+";'>"+m[5]+"</td>";
	    if(m[1])
	      html+="<td title='"+m[0]+"' style='width: "+this.options.cellSize+"px; background-color: "+this.options.panelBg+"; border: 1px solid "+this.options.panelBg+";' "+
	      "onmouseover='if("+m[2]+") {this.style.backgroundColor=\""+this.options.cellBg+"\"; this.style.borderColor=\""+this.options.cellBorderBg+"\"; this.getElementsByTagName(\"img\")[0].src=\""+this.options.imgdir+"/"+m[4]+"\";}'"+
	      "onmouseout='this.style.backgroundColor=\""+this.options.panelBg+"\"; this.style.borderColor=\""+this.options.panelBg+"\"; this.getElementsByTagName(\"img\")[0].src=\""+this.options.imgdir+"/"+m[3]+"\"'"+
	      ev+"='if("+m[2]+") {"+m[1]+"};'>"+
	      "<img src='"+this.options.imgdir+"/"+m[3]+"'></td>";
	  }
	}
	html+="</tr></table>";
	div.innerHTML=html;
    }
};


_contextMenu = Class.create();
_contextMenu.prototype = {
    initialize : function(container, options) {
    	if(!container) return;
	this.container = $(container);
	this.items = new Object();
	this.setOptions(options);
	this.div = document.createElement('div');
	this.container.appendChild(this.div);
	if(!this.options.className) {
	var css="display: none; background-color: #ffffff; border: 1px solid #555555; width: 120px;" + 
	    "font-size: 10px; font-family: verdana, sans; cursor: default; padding: 1px;";
	}else $(this.div).addClassName(this.options.className);
	css+="position: absolute;";
	this.div.style.cssText=css;

    },
    setOptions: function(options) {
	this.options = {
	    imgdir	: 'images',
	    className	: null,
	    bgOn 	: '#7CA4BD',
	    bgOff 	: '#ffffff',
	    bgImgOn 	: '#4c7b98',
	    bgImgOff 	: '#cccccc',
	    stopEvent	: true
	
	}
	Object.extend(this.options, options || {});
    
    },
    create: function(menu,event) {
	this.hide();
	this.div.style.top=Event.pointerY(event)+'px';
	this.div.style.left=Event.pointerX(event)+'px';
        var html="<table border=0 cellpadding=0 cellspacing=0 width='100%'>";
	var j,m;
	for (var i=0; i < menu.length ; i++) {
	  j=menu[i];      
	  if(j=='/') {
	    html+="<tr><td bgcolor='"+this.options.bgImgOff+"' ></td><td align='center' style='height: 2px; border: 0px solid black;'><hr style='margin: 0;' height='1' width='98%'></td></tr>";
	    continue;
	  }
	  if(this.items[j]) {
	    m=this.items[j];
	    var color="#000";
	    if(!eval(this.items[j][2])) {
	        html+="<tr height='22'>"; color="#808080";
	    }else {
		html+="<tr height='22' onmouseover='this.style.backgroundColor=\""+this.options.bgOn+"\";"+
		"this.getElementsByTagName(\"td\")[0].style.backgroundColor=\""+this.options.bgImgOn+"\";' "+
		"onmouseout='this.style.backgroundColor=\""+this.options.bgOff+"\"; "+
		"this.getElementsByTagName(\"td\")[0].style.backgroundColor=\""+this.options.bgImgOff+"\";' "+
		"onclick='"+m[1]+";'>";
	    }
	    html+="<td width='24' align='center' bgcolor='"+this.options.bgImgOff+"' >";
	    if(m[3]) html+="<img align='absmiddle' src='"+this.options.imgdir+"/"+m[3]+"'>";
	    html+="</td><td>&nbsp;<font color='"+color+"'>"+m[0]+"</font></td></tr>";
	  }
	}
	html+="</table>";
	this.div.innerHTML=html;
	this.div.style.display='block';
	if(this.options.stopEvent) Event.stop(event);
	return this.div;
    },
    hide: function() {
	if(this.div) this.div.style.display='none';
    }
};
