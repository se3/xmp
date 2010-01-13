sys = new Object();
sys.wins = new Array();

sys.ind=0;

sys.run = function () {
    var w;
    if(sys.wins.length < 4) {
	sys.ind=sys.wins.length;
	var div = "<div><acronym title='"+sys.strClear+"' ><div title='"+sys.strClear+"' onclick='sys.clearWin("+sys.ind+")' class='dialog_clear'></div></acronym></div>"
	w=new Window({width: 600, height: 350, destroyOnClose: false, effectOptions: {duration: 0.2},hideEffect: Element.hide, recenterAuto: false,customTitleDiv: div});
	//w.getContent().style.backgroundColor='red';
	$(w.getId()+'_row2').style.backgroundColor='#000000';
	sys.wins.push({win: w, html : '',cd: fm.folder ? fm.folder: sys.tDir});
	if (!sys.observer) {
	    sys.observer = { onFocus: function(eventName,win) { for( var i=0; i < sys.wins.length; i++) if (sys.wins[i].win == win) { setTimeout(function() { try { sys.wins[i].el.focus();} catch(e) {}; },20); return; } } };
	    Windows.addObserver(sys.observer);
	}
    }  else {
	if(++sys.ind > 3) sys.ind=0;
	w=sys.wins[sys.ind].win;
	sys.wins[sys.ind].cd=fm.folder ? fm.folder: sys.tDir;
    
    }
    w.showCenter(); 
    sys.setHtml('',sys.ind);
}
sys.clearWin = function(ind) {
    sys.wins[ind].html='';
    sys.setHtml('',ind);

}

sys.setHtml = function(html,ind) {
    var com = sys.wins[ind].el ? sys.wins[ind].el.value : '';
    var dir = fm.baseName(sys.wins[ind].cd);
    if(com)  sys.wins[ind].html+="<table width='100%' border=0 style='font-size: 11px;font-family: verdana,sans;'><tr><td style='width: 5%;' nowrap>["+sys.user+"@ "+dir+"]#</td>"+
	"<td>"+com+"</td></tr></table>";
    sys.wins[ind].html += html;	    
    if(sys.wins[ind].el) { sys.wins[ind].el.remove(); sys.wins[ind].el=null; }
    
    var shell="<table width='100%' border='0' style='font-size: 11px;font-family: verdana,sans;'><tr><td width='5%' nowrap='nowrap'>["+sys.user+"@ "+dir+"]#</td>"+
    "<td><input type='text' onkeyup='sys.onKeyUp(event,"+ind+")' id='__sYsInPuT__"+ind+"' name='__sYs__"+ind+"' style='width: 100%; color: white; border: 0; font-family: verdana,sans;font-size: 11px;background-color: #112233;' autocomplete='off'/>"+
    "</td></tr></table>";
    sys.wins[ind].win.setHTMLContent(sys.wins[ind].html + shell);
    sys.wins[ind].win.setTitle("<div align='left' style='width: 100%'>[ #" +(ind+1)+" ] "+sys.wins[ind].cd+"</div>");
    sys.wins[ind].el=$('__sYsInPuT__'+ind);
    setTimeout(function() { try { sys.wins[ind].el.focus();} catch(e) {} },20);
}


sys.onKeyUp = function(event,ind) {

    if(event.keyCode != 13) return;;
    var url="modules/System/shell.php";
    var a=sys.wins[ind].el.value;
    var pb="action="+encodeURIComponent(a)+"&dir="+encodeURIComponent(sys.wins[ind].cd)+"&ind="+ind;    
    fm.ajaxTimeout=fm.shellTimeout;
    new Ajax.Request(url, {postBody: pb,
	onComplete: function (t) {
	    if(t.responseText) {
		 t.responseText.evalScripts();
		 sys.setHtml(t.responseText.stripScripts(),ind);
		 sys.wins[ind].win.setStatusBar('last command: '+a);

	    }
	}});
}
