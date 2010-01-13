/*-------------------------------------------------------------------------
 *  Copyright (c) 2007 Nickolay Shestakov
 *
 *  This software is freely distributable under the terms of an 
 *  GNU General Public License version 2.
 *
 *--------------------------------------------------------------------------*/

_fileManager = Class.create();
_fileManager.prototype = {
    
    initialize : function(container, options) {
	if(container) this.container = $(container);
	this.folder = '';
	this.select = new Array();
	this.selectExt = '';
	this.audioExt = Array('wav','gsm','mp3','ulaw','ul','al','mu','alaw','g729','g722','ogg','pcm','sln','g723','vox','au','wav49');
	this.callToPhoneAudio = Array('wav','gsm','ulaw','ul','al','mu','alaw','g729','g722','ogg','pcm','sln','g723','vox','au','wav49');
	this.playingAudio = Array('mp3','wav','wav49');
	this.lookingFiles = Array('tar','gz','zip','bz2','pdf','cnf','conf','cfg','ael','txt','php','htm','html','ini','log','js','css','pl','doc','agi','tiff','tif','jpeg','png','gif','jpg');
	this.editingFiles = Array('conf','cfg','ael','txt','php','htm','html','ini','log','js','css','pl','agi');
	this.videoExt = Array('h263','h264');
	this.archivExt = Array('tar','gz','zip','bz2');
	this.clip = new Object();
	this.clip.action ='';
	this.clip.buffer = new Array();
	this.right = new Array();
	this.bgColor = '#ffffff';
	this.items = new Object();
	this.hlfiles= new Array();
	this.menuLeft = new Object();
	this.menuRight = new Object();
	this.leftExtraItems = new Array();
	this.rightExtraItems = new Array();
	this.hiddenExtraItems = new Array();
	this.leftContextExtraItems = new Array();
	this.rightContextExtraItems = new Array();
	this.topDirs = new Array();
	this.cashDirs = new Object();
	this.wwwdir = 'fm/';

	this.imgFolderClosed='folder_closed3.gif';
	this.imgFolderOpened='folder_open3.gif';
	this.msgContainer='filemanager-message';
	this.srvContainer='fm-service';
	this.tree = new Object();
	this.dirContent = new Object();
	this.leftId = new Object();
	this.rightId = new Object();
	this.setOptions(options);
	if(!this.options.theme) this.options.theme='Original';
	this.imgdir = 'themes/'+this.options.theme+'/images/';
	this.theme=this.options.theme;

    },
    setContainer: function(container) {
	this.container = $(container);
    },
    setOptions: function(options) {
	this.options = {
	    fColor	: '#000000',
	    sfColor	: '#ffffff',
	    sfBgColor	: '#34548f'
	}
	Object.extend(this.options, options || {});
    
    },
    isSelected: function(file) {
	if (this.select.indexOf(file) == -1) return false;
	return true;
    },

    isValidDir: function(dir) {
	if(dir == "") return false;
	for (var i=0; i < this.topDirs.length; i++)
	    if(dir.indexOf(this.topDirs[i] + '/') !== -1) break;
	if(i == this.topDirs.length) return false;
	return true;
	
    },
    isTopDir: function(dir) {
	if (this.topDirs.indexOf(dir) == -1) return false;
	return true;
    },
    highliteFiles: function(color) {
	if(!this.hlfiles.length) return;
	if(!color) var color='#91ce92';
	for( var i=0; i < this.hlfiles.length; i++) {
	    var f=this.hlfiles[i];
	    if($(this.rightId[f])) $(this.rightId[f]).style.backgroundColor=color;
	}
	this.hlfiles.clear();    
    },
    unhLite: function(id) {
	if(!$(id)) return;
	$(id).style.backgroundColor=this.bgColor;
	$(id).style.color=this.options.fColor;
    },
    hLite: function(id) {
	if(!$(id)) return;
	$(id).style.backgroundColor=this.options.sfBgColor;
	$(id).style.color=this.options.sfColor;
    },
    moveFiles: function(action) {
	this.clip.buffer.clear();
	this.clip.buffer=this.select.compact();
	this.clip.action=action;
    },
    getSelectExt: function () {
	if(!this.select.length) return '';
	var ext=this.fileExt(this.select[0]);
	if(!ext) return '';
       	for(var i=1; i < this.select.length; i++){
	      if(ext != this.fileExt(this.select[i])) return '';
	}
	return ext;
    },
    isExtracting: function(ext) {
	if (this.archivExt.indexOf(ext.toLowerCase()) == -1) return false;	    
	return true;
    },
    isAudio: function (ext) {
	if (this.audioExt.indexOf(ext.toLowerCase()) == -1) return false;	    
	return true;
    
    },
    isPlaying: function (ext) {
	if (this.playingAudio.indexOf(ext.toLowerCase()) == -1) return false;	    
	return true;
    
    },
    isCallToPhone: function (ext) {
	if (this.callToPhoneAudio.indexOf(ext.toLowerCase()) == -1) return false;	    
	return true;
    
    },
    isLooking: function (ext) {
	if (this.lookingFiles.indexOf(ext.toLowerCase()) == -1) return false;	    
	return true;
    
    },
    isEditing: function (ext) {
	if (this.editingFiles.indexOf(ext.toLowerCase()) == -1) return false;	    
	return true;
    
    },
    isVideo: function (ext) {
	if (this.videoExt.indexOf(ext.toLowerCase()) == -1) return false;	    
	return true;
    
    },
    selectAll: function () {
    	this.select=this.right.slice(0);
	var ext = this.fileExt(this.right[0]);
	var h=$('fm_right').getElementsByTagName('a');
	var c;
	for(var i=0; i < h.length; i++){
	   c=h[i].id.charAt(h[i].id.length-1);
	   if(h[i].id && c != 'n') {
		h[i].style.backgroundColor=this.options.sfBgColor;
		h[i].style.color=this.options.sfColor;
	   }
	}
	for (k in this.rightId) { if(ext && (ext != this.fileExt(k))) { ext =''; break;}}
	this.selectExt = ext;

    },
    unSelectAll: function() {
	var h=$('fm_right').getElementsByTagName('a');
	var len=this.select.length;
	if(len > 100 || (h.length-len) < 20) {

	    var c;
	    for(var i=0; i < h.length; i++){
		c=h[i].id.charAt(h[i].id.length-1);
		if(h[i].id && c != 'n') {
		    h[i].style.backgroundColor=this.bgColor;
		    h[i].style.color=this.options.fColor;
		}
	    }
	}else {
	    for(var i=0; i < this.select.length; i++) {
		this.unhLite(this.rightId[this.select[i]]);
	    }
	
	}
	this.selectExt='';
	this.select.clear();
    },
    selectFile: function(file,event){
	//if(this.right.indexOf(file) == -1)  return;
	var shift=false;
	var is=this.isSelected(file);
	if(event) shift = (event=='1')? 1 : event.shiftKey;
	if(!shift) {
	    if((this.select.length < 2) || !is) {
		this.unSelectAll(); 
		this.select.push(file);
	    } 
	} 
	this.hLite(this.rightId[file]);
	if(shift){
	    if(is){
		this.select=this.select.without(file);
		this.unhLite(this.rightId[file]);
	    }else this.select.push(file);
	}
	this.selectExt=this.getSelectExt();
	return false;
    },
    inTree: function(dir) {
	if(!dir) return false;
	if($(this.leftId[dir])) return true;
	return false;
    },
    isDir: function(dir) {
	if(!dir) return false;
	if(this.tree[dir]) return true;
	return false;
    },
    getTree: function(dir) {
       var a = new Array();
       a[0]=dir; var i=1;
       while(!this.isTopDir(dir)) {
          dir=this.dirName(dir);
	  a[i++]=dir;
       }
       return a;
    
    },
    isFolderVisible: function(dir) {
    	if(!dir) return false;
	var a=this.getTree(dir); 
	a.shift();
	for (var i=0; i < a.length; i++) {
	    if($(this.leftId[a[i]]+'-div').style.display != 'none') return true;
	}
	return false;	
    },
    isOpen: function(dir) {
	if(!dir) return false;
	if(this.tree[dir]) return this.tree[dir].open;
	return false;
    },
    closeFolder: function(dir) {
	if(this.inTree(dir)) {
	    $(this.leftId[dir]+'-folder').src=this.imgdir+this.imgFolderClosed;
	    this.unhLite(this.leftId[dir]);
	}
    },
    openFolder: function(dir) {
    	if(this.inTree(dir)) {
	    $(this.leftId[dir]+'-folder').src=this.imgdir+this.imgFolderOpened;
	    this.hLite(this.leftId[dir]);
	}
    
    },
    changeFolder: function(from,to) {
	if(from != to) this.closeFolder(from);
    	this.openFolder(to);
    	this.folder = to;
    	this.select.clear();
	this.selectExt='';
    },
    createTree: function(dir) {
	this.tree[dir] = new Object();
	this.tree[dir].open = false;
    
    },
    openTree: function(dir,content) {
	this.tree[dir].open = true;
	var id=this.leftId[dir];
	
	if(content)  Element.update($(id+'-div'),content);
	$(id+'-div').style.display='block';
	//new Effect.BlindDown($(id+'-div'),{duration: 0.3})
	if($(id+'-div').innerHTML.length >10) {
	    if($(id+'-treelink').innerHTML) $(id+'-tree').src=$(id+'-tree').src.replace(/(plus)/,'minus');
	    else $(id+'-treelink').innerHTML="<img id='"+id+"-tree' align='absmiddle' src='"+this.imgdir+"minus.gif'>&nbsp;";	        
	} else { $(id+'-treelink').innerHTML=''; $(id+'-div').style.display='none'; }
    },
    closeTree: function(dir) {
    	var id=this.leftId[dir];
	if(!this.tree[dir]) return;
	this.tree[dir].open = false;
	$(id+'-div').style.display='none';
	//new Effect.BlindUp($(id+'-div'),{duration: 0.2})
	
	if($(id+'-div').innerHTML.length > 10) {
	    if($(id+'-treelink').innerHTML) $(id+'-tree').src=$(id+'-tree').src.replace(/(minus)/,'plus');
	    else $(id+'-treelink').innerHTML="<img id='"+id+"-tree' align='absmiddle' src='"+this.imgdir+"plus.gif'>&nbsp;";	        
	}else  $(id+'-treelink').innerHTML='';
    
    },
    getParString: function(par,str) {
	par.compact();
	for (var i=0, s=''; i < par.length; i++) {
	    s+='&'+str+'['+i+']='+encodeURIComponent(par[i]);
	}
	return s;
    },
    fileExt: function(file) {
	return file.substr(file.lastIndexOf('.')+1);
    },
    baseName: function(file) {
	return file.substr(file.lastIndexOf('/')+1);
    },
    dirName: function(file) {
	var d=file.substr(0,file.lastIndexOf('/'));
	if(d=='') return '/';
	return d;
    },
    showMessage	: function (msg,container,hide,img,duration) {
	    var s='';
	    if(!msg) return;
	    if(!duration) duration=3500;
	    if(!container) container='module-note';
	    Element.show(container);
	    if(img) s="<img align='absmiddle' src='"+this.imgdir+img+"'>&nbsp;";
	    if(hide) {
		s+=msg + "&nbsp;&nbsp;<a title='"+this.strHide+"'  href='javascript:void(0)'>"+
		"<img onclick=\"$('"+container+"').hide()\" align='absmiddle' src='"+this.imgdir+"close2.gif'></a>";	
		$(container).innerHTML=s;
		return;
	    }	    
	    $(container).innerHTML=s+msg;
	    setTimeout(function() {
		if($(container)) {
		    //new Effect.BlindUp(container,{duration: 0.2})
		    new Effect.Fade(container,{duration: 0.2})
		}   
	    },duration);
    },
    toolTip	: function(id,event,msg,options) {
	    if(!msg || (!id && !event)) return;
	    if(!options) options={};
	    if(!options.duration) options.duration=3000;
	    var container = options.container ? $(options.container) : document.body;
	    if(id && (typeof id == 'string')) id=document.getElementById(id);
	    var div = document.createElement('div');
	    container.appendChild(div);
	    div.id="__fm_tooltip_div__" + Math.round(Math.random()*1000000000);
	    var css = "display: none; z-index: 1000; overflow: hidden; background-color: #eeeecc; border: 1px solid #34548f; width: 200px;font-size: 11px; font-family: verdana,arial; position: absolute;"
	    if(options.style) css+=options.style;
	    div.style.cssText=css;
	    if(!options.close) div.style.padding='5px';
	    if(options.width) div.style.width=options.width;
	    if(options.color) div.style.color=options.color;
	    if(options.bgcolor) div.style.backgroundColor=options.bgcolor;
	    if(id) {
		var offsetTop = options.offsetTop ? options.offsetTop : id.offsetHeight ? id.offsetHeight : 15;
		var offsetLeft= options.offsetLeft ? options.offsetLeft : 0;
		Position.clone(id,div,{setWidth: false, setHeight: false, offsetTop: offsetTop, offsetLeft: offsetLeft});
	    }else { 	div.style.top=Event.pointerY(event)+'px';	
			div.style.left=Event.pointerX(event)+'px'; 
	    }
	    if(options.close) {
		var w=div.getWidth()-1;
		var s = "<table cellpadding='0' cellspacing='0' style='width: "+w+"px;color: black; background-color: #b0c2e7; margin-bottom: 5px;'><tr><td align='center'>";
		if(options.title) s+=options.title; s+="&nbsp;</td><td align='right' valign='top' width='15'>";
		s+="<a href='javascript:void(0)'><img onclick=\"Element.remove('"+div.id+"');";
		if(isIE) s+="Element.remove('"+div.id+"_iefix');";
		s+="\" align='top' src='"+this.imgdir+"close3.gif'></a></td></tr></table>";
		msg = s + msg;
	    }
	    if(options.img) {
		var src = (options.img.indexOf('/') !== -1) ? options.img : this.imgdir+options.img;
		msg = "<img align='absmiddle' src='"+src+"'>&nbsp;" + msg;
	    }
	    div.innerHTML=msg;
	    Element.show(div);
	    if(isIE) {
	    	    new Insertion.After(div, 
    			'<iframe id="' + div.id + '_iefix" '+
    			'style="display:none;position:absolute;filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);" ' +
    			'src="javascript:false;" frameborder="0" scrolling="no"></iframe>');
		    var iefix=document.getElementById(div.id+'_iefix');
		    Position.clone(div, iefix, {setTop:(!div.style.height)});
		    iefix.style.zIndex = 999;
		    Element.show(iefix);
	    
	    }
	    if(options.close) { this.hideToolTip(); this.tooltipDiv = div.id; this.tooltip_iefix=div.id+'_iefix'; }
	    if(options.hlight || !options.close) {
		setTimeout(function() {
		    if(!options.close) {
			container.removeChild(div);
			if(iefix) container.removeChild(iefix);

		    }
		    if(id) { id.disabled=false; id.focus(); }
		},options.duration);
	    }
	    if(id && options.hlight) {
		var hcolor = options.hcolor ? options.hcolor : '#f6281d';
	    	id.disabled=true;
	    	new Effect.Highlight(id,{startcolor: hcolor});
	    
	    }
	    return div;
    },
    hideToolTip	: function() {
		if($(this.tooltipDiv)) Element.remove(this.tooltipDiv);
		if($(this.tooltip_iefix)) Element.remove(this.tooltip_iefix);
	   this.tooltipDiv=this.tooltip_iefix=null;
    },
    checkInput	: function (id,type,msg,options) {
		if(!id) return;
		if(!options) options = {};
		id=$(id);
		var s=id.value;
		if(type == "integer" && isInteger(s)) return true;
		else if(type == "float" && isFloat(s)) return true;
		else if(type == "empty" && s.length) return true;
		else if(type == "email" && isValidEmail(s)) return true;
		else if(type == "symbols") {
		    if(!options.symbols || !options.symbols.length) return true;
		    for(var i=0; i < options.symbols.length; i++) {
			if(s.indexOf(options.symbols[i]) !== -1) break;
			
		    }
		    if(i == options.symbols.length) return true;
		
		}
		if(!msg) msg=' ';
		if(!options.img) options.img='warning2.gif';
		if(options.hlight == undefined) options.hlight=true;
		//IE bugfix
		if(isIE) id.scrollLeft=id.scrollTop=0;
		this.toolTip(id,0,msg,options);
		return false;

    },
    checkInputs	: function(req,filters) {
		for(var i=0; i < req.length; i++) {
		    if(!this.checkInput(req[i],'empty',ams.strFieldMustNotBeEmpty)) return false;
		}
		for(i=0; i < filters.length; i++) {
		    var type=filters[i]['type'];
		    var options = {};
		    if(type == "symbols") options.symbols = filters[i]['options'];
		    if(!this.checkInput(filters[i]['id'],type,filters[i]['msg'],options)) return false;
		}
		return true;
    },
    hideSelect	: function() {
		var a=$('frame-module-content').getElementsByTagName('select');
		for (var i=0; i < a.length; i++) a[i].style.visibility='hidden';
    },
    showSelect	: function() {
		var a=$('frame-module-content').getElementsByTagName('select');
		for (var i=0; i < a.length; i++) a[i].style.visibility='';	
    },
    setLoading	: function() {
		this.loading = true;
		this.loadTimeoutVal=1;
		var html="<table border='0' cellspacing='10' "+
		"style='width: 200px; background-color: white; border: 1px solid #aaaaaa; '><tr><td id='__load_timeout_msg__'>"+
		fm.strHttpLoading+"1&nbsp;</td><td><img align='absmiddle' src='images/spinner.gif' alt='loading'></td></tr></table>";
		Dialog.info(html,{className: 'alert_lite', width: 250, height: 100, showEffect: Element.show, hideEffect: Element.hide, hideEffectOptions: {duration: 0.1}, showProgress: false});
		setTimeout("fm.loadDialogTimeout()",1000);
		
    },
    cancelLoading	: function() {
		this.loading = false;
		setTimeout("Dialog.closeInfo()",1000);
    },
    loadDialogTimeout: function() {
	if(!this.loading) return;
	if($('__load_timeout_msg__')) {
	    this.loadTimeoutVal++;
	    $('__load_timeout_msg__').innerHTML=this.strHttpLoading+this.loadTimeoutVal+'&nbsp;';
	    setTimeout("fm.loadDialogTimeout()",1000);
	    return;
	}
    },
    hideSrv: function() {

	if(fm.srvWin) fm.srvWin.hide();
	
    },
    postRename: function(type,oldname,newname) {
    	if(type == 'left') {
	    var up = this.dirName(newname);
	    this.tree[up].open = false;
	    this.showTree(up,true);
	    //this.openFolder(up);

	}else {
	    this.hlfiles.push(newname);
	    this.showDir(this.folder);
	}
    
    },
    postDeleteDir: function() {
	this.leftId[this.folder]=this.tree[this.folder]=null;
	this.folder=this.dirName(this.folder);
	this.closeTree(this.folder);
	this.showTree(this.folder,true);
	this.showDir(this.folder);
    },
    postDeleteFiles: function() {
        var f,d;
	for (var i=0; i < this.select.length ; i++ ){
	    f=this.select[i];
	    if(this.isDir(f)) {
		this.leftId[f]=this.tree[f]=null; d=true; 
	    }
	
	}
	if(d && this.isOpen(this.folder)) {
	    this.closeTree(this.folder);
	    this.showTree(this.folder,true);
	}
	this.showDir(this.folder);
    },
    postMkDir: function(newdir) {
	var updir=this.dirName(newdir);
	//if(this.folder == updir) {
	    this.closeTree(updir);
	    this.showTree(updir,true);
	//}
	this.hlfiles.push(newdir);
	//this.showDir(this.folder);
	this.showDir(updir);
	this.hideSrv();
    }
}

fm = new _fileManager('',{});

fm.callInProgress = function (transport) {
	switch (transport.readyState) {
	    case 1: case 2: case 3:
		return true; break;
		//case 4 & 0
	    default: return false; break;
	}
}

globalHandler = {
	onCreate: function (request) {
	    request.loadingInProgress=setTimeout(
	        function() { fm.setLoading(); },1000);
	    request.timeoutId=setTimeout(
		function() {
		        if(fm.callInProgress(request.transport)){
			  if($('__load_timeout_msg__')) $('__load_timeout_msg__').innerHTML="<font color='red'>"+fm.strHttpTimeout+"</font>";
			  request.transport.abort();	
			}
		},(fm.ajaxTimeout * 1000));	

	},
	onComplete: function (request,t) {
	    clearTimeout(request.timeoutId);
	    clearTimeout(request.loadingInProgress);
	if(fm.loading) fm.cancelLoading(); 
	fm.ajaxTimeout=fm.httpTimeout;
    }
}



fm.showHidden = function(id,event) {

     if(!this.folder) return false;
     var m=Array('edit','view','selectall','rename');
     var ext,len = this.select.length;
     ext = this.selectExt.toLowerCase();
     var m2=Array('/');
     if(ext && len) {
	var l = m2.length;                           
        if(this.isPlaying(ext) && ((len == 1) || ext == 'mp3')) 
	    m2=m2.concat('play');
	if(this.isExtracting(ext) && len == 1) m2=m2.concat('extract');    
        if(l == m2.length) m2.shift();
	m=m.concat(m2);
    }
    var mdiv=this.cMenu.create(m,event);
    Position.clone(id,mdiv,{setWidth: false, setHeight: false,offsetTop: 15});
    return false;
}

fm.contextMenuLeft = function(dir,event) {
 var m=contextMenu2;
 if(dir=='') {
    if(!this.folder) return false;
    else dir=this.folder;
 } 

 if(this.inTree(dir) && !this.isTopDir(dir) && this.isFolderVisible(dir)) m=m.concat('rename_dir');
 if(!this.folder) this.folder=dir;
 this.showDir(dir);
 this.cMenu.create(m,event);
 return false;
}

fm.downloadFiles = function () {
 $('fm-service-form').par.value=this.select;
 $('fm-service-form').action="fm/downloadfiles.php";
 $('fm-service-form').submit();
}

fm.view = function () {
    var file=this.select[0];
    var ext=this.fileExt(file).toLowerCase();
    var type;
    var menubar='no';
    var scrollbars='no';
    var toolbar='no';
    switch (ext) {
	case 'tar': case 'gz': case 'bz2': case 'zip': fm.viewArchive(); return;
	case 'pdf': type='pdf'; break;
	case 'doc': type='doc'; break;
	case 'jpeg' : case 'jpg': case 'png': 
	case 'tif': case 'tiff': case 'html': type=ext; break;
	case 'gif': if(isIE) type='html'; else type=ext; break;
	default: type='txt'; menubar='yes'; break;
    }

    var wt="top=" + Math.ceil(screen.availHeight * 0.1);
    var wl=", left=" + Math.ceil(screen.availWidth * 0.15);
    var url="lib/loadfile.php?file="+encodeURIComponent(file)+"&type="+type;
    var h = Math.ceil(screen.availHeight * 0.75);
    var w = Math.ceil(screen.availWidth * 0.7);
    var id=type+'file'+Math.round(Math.random()*1000000000);
    if(type=='html') { scrollbars='yes'; menubar='yes'; toolbar='yes';}
    open(url, id, "height="+h+", width="+w+",status=0, toolbar="+toolbar+", menubar="+menubar+",resizable=1,scrollbars="+scrollbars+"," + wt + wl);
}
fm.viewArchive = function() {
    var url='modules/Archive/viewarchive.php';
    var pb="archive="+encodeURIComponent(fm.select[0]);
    new Ajax.Request(url,{ postBody: pb,
	onComplete: function(t) {
	    if(t.responseText) 
		    Element.update('fm_right',t.responseText);
	} });
}

fm.edit = function () {

    var file=this.select[0];
    var type;
    var wt="top=" + Math.ceil(screen.availHeight * 0.1);
    var wl=", left=" + Math.ceil(screen.availWidth * 0.18);
    var url="fm/editfile.php?file="+encodeURIComponent(file);
    //var h = Math.ceil(screen.availHeight * 0.75);
    var h = 600;
    var w = Math.ceil(screen.availWidth * 0.7);
    
    var id=type+'file'+Math.round(Math.random()*1000000000);
    open(url, id, "height="+h+", width="+w+",status=0,menubar=1,resizable=1,scrollbars=0," + wt + wl);
}

fm.play = function() {

    var ext=this.selectExt.toLowerCase();
    switch (ext) {
	case 'wav': this.playWav(this.select[0]);  break;
	case 'mp3': this.playMP3(); break;
	default: return;
    }
}

fm.playMP3 = function() {
    if(!fm.mp3playerWin) {
	fm.mp3playerWin = new Window({title: 'MP3 Player', width: 230, height: 50, destroyOnClose: false, recenterAuto: false,showEffect: Effect.Appear,effectOptions: {duration: 0.3},maximizable: false,minimizable: false, resizable: false,statusbar: true});
	fm.mp3playerObserver={ onClose: function(eventName,win) {if(win == fm.mp3playerWin) fm.player.stop(); } };
	Windows.addObserver(fm.mp3playerObserver); 
	fm.mp3playerWin.setContent('_mp3player_');
	$('_mp3player_').show();
	fm.mp3playerWin.showCenter();
	fm.mp3playerWin.getContent().style.overflow='hidden';
    } else if(!Element.visible(fm.mp3playerWin.getId())) fm.mp3playerWin.show();
    fm.player.load(fm.select);
}

fm.playWav = function(file) {
    
    if(!fm.wavPlayer) {
	fm.wavPlayer = new Window({title: 'Media Player', width: 300, height: 41, destroyOnClose: false, recenterAuto: false, showEffect: Effect.Appear,effectOptions: {duration: 0.3},maximizable: false,minimizable: false, resizable: false});
	Windows.addObserver( { onClose: function(eventName,win) { if(win == fm.wavPlayer) win.setHTMLContent(""); } });
	fm.wavPlayer.showCenter();
    } else if(!Element.visible(fm.wavPlayer.getId())) fm.wavPlayer.show();
    var s="<div valign='top' style='background-color: #dddddd; width: 100%; height: 100%;'><embed src='lib/loadfile.php?file="+encodeURIComponent(file)+"&type=wav"+
	"' autostart='true' loop='false' width='300' height='40' valign='top'></embed></div>";
    fm.wavPlayer.setHTMLContent(s);
    fm.wavPlayer.setStatusBar('File: '+fm.baseName(file));
}

fm.contextMenuRight = function(event) {
 if(!this.folder) return false;
 var m=contextMenu1;
 var ext,len = this.select.length;
 ext = this.selectExt.toLowerCase();
 if(ext && len) {
    m=m.concat('/'); var l = m.length;                           
    if(this.isPlaying(ext) && ((len == 1) || ext == 'mp3')) 
	m=m.concat('play');
    if(l != m.length) { m=m.concat('/'); l = m.length; }
    if(this.isEditing(ext)) m=m.concat('edit'); 
    if(this.isLooking(ext)) m=m.concat('view');
    if(this.isExtracting(ext)) m=m.concat('extract');
    if(l != m.length) m=m.concat('/'); 
    if(len ==1) m=m.concat('rename');
    m=m.concat('download');                            

 }
 this.cMenu.create(m,event);
 return false;
}

fm.rename = function(type) {

    var f,id;
    if(type=='left') { f=this.folder; id=this.leftId[f];   }
    else { f=this.select[0]; id=this.rightId[f];  }
    if(!$(id)) return;
    var file=this.baseName(f);
    var el = document.createElement('input');
    el.type = 'text';  el.name=el.id='rn'+id; el.value = file;
    el.size = file.length +1; el.cssStyle = "font-size: 11px;";
    el.ondblclick = el.onkeyup = fm.doRename.bindAsEventListener(this,el,type,f);
    el.saveHTML=$(id+'-cell').innerHTML;
    $(id+'-cell').innerHTML="";
    $(id+'-cell').appendChild(el);
    el.style.backgroundColor="#baeea5";
    el.focus();

}

fm.doRename = function(evt,p,type,oldname) {
    if(evt.keyCode && evt.keyCode != 13) return;
    var id=p.id.substr(2)+'-cell';
    var newname=this.dirName(oldname)+'/'+p.value;
    if(oldname == newname) {
        $(id).innerHTML=p.saveHTML;
	if(type == 'left') {
	    if(oldname != fm.folder) fm.unhLite(fm.leftId[oldname]);
	} else {
	    if(!fm.isSelected(oldname)) fm.unhLite(fm.rightId[oldname]);
	}
	return;
    }
    var url='fm/rename.php';
    var pb="oldname="+encodeURIComponent(oldname)+"&newname="+encodeURIComponent(newname);
    new Ajax.Request(url,{
	postBody: pb,
	onComplete: function(t) {
	    if(t.responseText != "success") {
		fm.showMessage(t.responseText,'filemanager-message',1,'warning.gif');
		$(id).innerHTML=p.saveHTML;
		if(type == 'left') {
		    if(oldname != fm.folder) fm.unhLite(fm.leftId[oldname]);
		} else {
		    if(!fm.isSelected(oldname)) fm.unhLite(fm.rightId[oldname]);
		}
	    }
	    else fm.postRename(type,oldname,newname);		
	}
    });
}

fm.deleteFiles=function() {
    if(!fm.select.length) return;
    if(!confirm(fm.strConfirmDelete)) return;
    var url='fm/deletefiles.php';
    var pb="dir="+encodeURIComponent(this.folder);
    if(this.select.length) pb+=this.getParString(this.select,'files')

    new Ajax.Request(url,{
	postBody: pb,
	onComplete: function(t) {

	    if(t.responseText=="success") fm.postDeleteFiles();
	    else fm.showMessage(t.responseText,'filemanager-message',1,'warning.gif');
	    
	}
    });
}

fm.pasteFiles = function() {
    if(!this.folder) return;
    if(!this.clip.buffer.length) return;
    if(!this.clip.action) return;
    var url='fm/pastefiles.php';
    var pb="dir="+encodeURIComponent(this.folder)+"&action="+fm.clip.action;
    this.hlfiles.clear();
    pb+=this.getParString(this.clip.buffer,'files');
    fm.errorMsg='';
    new Ajax.Request(url,{
	postBody: pb,
	onComplete: function(t) {
	    
	    if(t.responseText) {
	        var msg=t.responseText.stripScripts();
	        if(msg != 'success') fm.showMessage(msg,'filemanager-message',1,'warning.gif');
	        else {
	    	    t.responseText.evalScripts();
	    	    fm.showDir(fm.folder);
	        }
	    } 
	}
    });
}

fm.checkValidDir = function(dir) {
    if(!this.isValidDir(dir)) {
	alert(fm.strNotValidDir+" " + dir);
	return false;
    }
    return true;
}

fm.call = function() {
    if(!fm.dial_exten || !fm.ast_chan || !fm.playToPhone) {
	fm.service('call',fm.select);
	return;
    }
    fm.playToPhone('call',fm.select[0]);
}

fm.service = function(srv,par,mod){

 var url;
 if(mod) url='modules/'+mod+'/srv'+srv+'.php';
 else  url='fm/srv'+srv+'.php';
 var pb="dir="+encodeURIComponent(this.folder);
 if(par) pb+=this.getParString(par,'par');

 new Ajax.Request(url,{
	postBody: pb,
	onComplete: function(t) {
	    if(t.responseText) {
		if(!fm.srvWin) fm.srvWin = new Window({title: 'Service', width: 650, height: 300, destroyOnClose: false, recenterAuto: true,showEffect: Effect.Appear,effectOptions: {duration: 0.3},maximizable: false, minimizable: false});
		fm.srvWin.getContent().update(t.responseText);
		fm.srvWin.showCenter();
	    }
	}
    });
}

fm.deleteDir=function() {
    if(!this.folder || this.isTopDir(this.folder)) return;
    if(!confirm(fm.strConfirmDeleteDir+" "+this.folder+" ?")) return;
    var url='fm/deletefiles.php';
    var pb="dir="+encodeURIComponent(this.folder)+"&files[0]="+encodeURIComponent(this.folder);
    new Ajax.Request(url,{ postBody: pb,
	onComplete: function(t) {
	    //alert(t.responseText);
	    if(t.responseText=="success") fm.postDeleteDir();
	    else fm.showMessage(t.responseText,'filemanager-message',1,'warning.gif');
	}
    });
}
fm.showFileInfo = function(file,event) {
    var url='fm/fileinfo.php';
    var pb="file="+encodeURIComponent(file);
    var id=fm.rightId[file];
    new Ajax.Request(url,{ postBody: pb,
	onComplete: function(t) {
	    if(t.responseText)
	      fm.toolTip(id,0,t.responseText,{close: 1, title: fm.strFileInfo,container: 'fm_right'});
	}
    });

}
fm.onClick = function(f,event) {
    this.selectFile(f,event);
    this.cMenu.hide();
    if(event) Event.stop(event);
}

fm.onDblClick = function(f) {
    var ext = this.fileExt(f).toLowerCase();
    if(!ext) return;
    if(fm.isLooking(ext)) fm.view(f);
    else if(fm.isPlaying(ext)) fm.play(f);
}

fm.onContextMenu = function(id,f,event) {
      clearTimeout(id.ft_timer); 
      if(!this.isSelected(f)) this.selectFile(f,event); 
      return this.contextMenuRight(event);

}
fm.onMouseOver = function(id,f,event) {
      var e= event.shiftKey ? 1:0;
      if(!this.isSelected(f)) id.style.backgroundColor='#c3c3c3';
      id.stimer=setTimeout(function () { fm.selectFile(f,e)  },700); 
      id.ft_timer=setTimeout(function () { fm.showFileInfo(f,event)  },2500); 
      this.cMenu.hide();
      if(event) Event.stop(event);
}

fm.onMouseOut = function(id,f) {
      if(this.isSelected(f)) id.style.backgroundColor='#34548f';
      else id.style.backgroundColor=fm.bgColor;
      clearTimeout(id.stimer); 
      clearTimeout(id.ft_timer); 
}

fm.showTree=function(dir,refresh){
    if(dir=="") return;
    if(!this.tree[dir]) this.createTree(dir);
    if(this.tree[dir].open) {
	this.closeTree(dir);
	return;
    }
    if(!refresh && $(this.leftId[dir]+'-div')) {
	if($(this.leftId[dir]+'-div').innerHTML) { this.openTree(dir); return; }
    }
    var url='fm/showtree.php';
    var pb="dir="+encodeURIComponent(dir)+"&pattern=*";
    new Ajax.Request(url,{ postBody: pb,
	onComplete: function(t) {
	    if(t.responseText) fm.openTree(dir,t.responseText);
	}
    });
}

fm.showDir=function(dir) {

    var url='fm/showdir.php';
    var pb="dir="+encodeURIComponent(dir);
    pb+="&pattern="+encodeURIComponent($F('r_pattern'));
    new Ajax.Request(url,{ postBody: pb,
	onComplete: function(t) {
	    if(t.responseText) {
		Element.update('fm_right',t.responseText);
		fm.changeFolder(fm.folder,dir);
		setTimeout("fm.highliteFiles()",100);
		$('fm-right-sub').innerHTML='<small>&nbsp;&nbsp;'+fm.strSelectionHelp+'</small>';
	    }
	}
    });

}
fm.initMenu=function() {
    fm.menuLeft['mkdir'] = Array(fm.strMakeDir,'fm.service(\"mkdir\")','fm.folder','mkdir_off.gif','mkdir_on.gif');
    fm.menuLeft['rmdir'] = Array(fm.strDeleteDir,'fm.deleteDir()','fm.folder','rmdir_off.gif','rmdir_on.gif');
    fm.menuLeft['rename_dir'] = Array(fm.strRename,'fm.rename(\"left\")','true','');
    fm.menuLeft['upload'] = Array(fm.strUploadFile,'fm.service(\"upload\")','fm.folder','upload_off.gif','upload_on.gif');

    fm.menuRight['extract'] = Array(fm.strExtract,'fm.service(\"extract\",fm.select,\"Archive\")','(fm.select.length==1) && fm.isExtracting(fm.selectExt)','rar_fm.gif');
    fm.menuRight['cut'] = Array(fm.strCut,'fm.moveFiles(\"cut\")','fm.select.length','cut_off.gif','cut_on.gif');
    fm.menuRight['copy'] = Array(fm.strCopy,'fm.moveFiles(\"copy\")','fm.select.length','copy_off.gif','copy_on.gif');
    fm.menuRight['paste'] = Array(fm.strPaste,'fm.pasteFiles(\"copy\")','fm.clip.buffer.length','paste_off.gif','paste_on.gif');
    fm.menuRight['delete'] = Array(fm.strDelete,'fm.deleteFiles()','fm.select.length','delete_off.gif','delete_on.gif');
    fm.menuRight['download'] = Array(fm.strDownload,'fm.downloadFiles()','fm.select.length','download_off.gif','download_on.gif');
    fm.menuRight['refresh'] = Array(fm.strRefresh,'fm.showDir(fm.folder)','fm.folder','refresh_off.gif','refresh_on.gif','');
    fm.menuRight['refresh'][5]="<input type='text' name='r_pattern' id='r_pattern' size='15' value='*'/>";
    fm.menuRight['play'] = Array(fm.strPlay,'fm.play()','fm.select.length','');
    fm.menuRight['rename'] = Array(fm.strRename,'fm.rename(\"right\")','fm.select.length==1','');
    fm.menuRight['view'] = Array(fm.strQuickView,'fm.view()','(fm.select.length == 1) && fm.isLooking(fm.selectExt)','view_off.gif','view_on.gif');
    fm.menuRight['edit'] = Array(fm.strEdit,'fm.edit()','(fm.select.length==1) && fm.isEditing(fm.selectExt)','edit.gif');
    fm.menuRight['selectall'] = Array(fm.strSelectAll,'fm.selectAll()','true','');
    fm.menuRight['hidden'] = Array();
    fm.menuRight['hidden'][5]="<img src='themes/"+fm.theme+"/images/m_off.gif' "+ 
    " onmouseover='if(fm.folder) this.src=\"themes/"+fm.theme+"/images/m_on.gif\"' "+
    " onmouseout='this.src=\"themes/"+fm.theme+"/images/m_off.gif\"' "+
    " onclick='if(fm.folder) fm.showHidden(this,event);' />";
    
    fm.topMenuLeft = new _Toolbar('top-menu-left',{className: 'menu-panel', imgdir: 'themes/'+fm.theme+'/images'});
    fm.topMenuRight = new _Toolbar('top-menu-right',{className: 'menu-panel',imgdir: 'themes/'+fm.theme+'/images'});
    fm.topMenuLeft.items=fm.menuLeft;
    fm.topMenuRight.items=fm.menuRight;

    
}	

loadModule=function(form,module,action,p) {
  var url=fm.www_dir+'/module.php';
  var f='';
  if(form) f='&' + Form.serialize(form);
  var pb ="&module=" + module + "&action=" + action + f;
  if(p) pb+='&' + p;
  new  Ajax.Request(url, { postBody: pb, 
	    	  onComplete:  function(t) {
			    if(t.responseText) {
			        Element.update('fm-right',t.responseText);
			    }
	}});
}
fm.createLeftToolbar = function() {
  var i = Array('/','mkdir','rmdir','upload','/');
  i=i.concat(fm.leftExtraItems);
  fm.topMenuLeft.create(i);

}
fm.createRightToolbar = function() {
  var i = Array('/','refresh','/','cut','copy','paste','delete','/','download','/');
  i=i.concat(fm.rightExtraItems);
  if(fm.rightExtraItems.length) i=i.concat('/','hidden');
  else i=i.concat('hidden');
  fm.topMenuRight.create(i);
}

fm.addLeftToolBar = function(menu,item) {
    if(item) fm.menuLeft[menu]=item;
    fm.leftExtraItems.push(menu);
}

fm.addRightToolBar = function(menu,item) {
    if(item) fm.menuRight[menu]=item;
    fm.rightExtraItems.push(menu);
}
fm.addContextLeftMenu = function(menu,item) {
    if(item) fm.menuLeft[menu]=item;
    fm.leftContextExtraItems.push(menu);

}
fm.addContextRightMenu = function(menu,item) {
    if(item) fm.menuRight[menu]=item;
    fm.rightContextExtraItems.push(menu);

}
fm.addHiddenMenu = function(menu,item) {
    if(item) fm.menuRight[menu]=item;
    fm.hiddenExtraItems.push(menu);

}

