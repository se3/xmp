Player = Class.create();
Player.prototype = {

    initialize	: function (options) {

      this.paused = true;
      this.stoped = true;
      this.info = false;
      this.list = new Array();
      this.playList = false;
      this.currentTrack = '';
      if(options == undefined) options = new Object();
      if(!options.swfLocation) options.swfLocation='swf/SoundBridge.swf';
      this.sound = new Sound(options);
      this.position = 0;
      this.frequency = 1000;
      this.isLoaded = false;
      this.duration = 0;
      this.bytesTotal = 0;
      this.pWidth = 230;
      this.wwwdir='fm/';
      if(!options.theme) options.theme='Original';
      this.imgdir='themes/'+options.theme+'/images/';
      this.display=$('_mp3player_display_');
      this.infoDiv=$('_mp3player_info_');
      this.msg=$('_mp3player_msg_');
      this.player=$('_mp3player_');
      this.playBtn=$('_mp3player_play_');
      this.stopBtn=$('_mp3player_stop_');
      this.pauseBtn=$('_mp3player_pause_');
      this.plistBtn=$('_mp3player_pl_button_');
      this.nextBtn=$('_mp3player_next_');
      this.prevBtn=$('_mp3player_prev_');
      this.divPL = $('_mp3player_pl_');
      this.time = $('_mp3player_time_');
      this.progressBar=$('_mp3player_progressbar_');
      this.intervalId=null;
      this.trackDur = 0;
      this.currentDur = 0;
      this.infoStr='';
      this.tInfo = null;
      this.infoStrLeft = 0;
      this.infoCount = 3;
      this.infoStrMargin = this.pWidth;
      
      this.registerCallback();      
      
    },

     onTimerEvent: function() {
      if(!$('_mp3player_')) {
	clearInterval(this.intervalId);
	return;        
      }

      if(this.paused || this.stoped) return;
      this.msg.innerHTML="Playing...";
      var isDurationOk = false;
      var position = this.sound.getPosition();
      if(!position) position = 0;
      if(position != this.position && position != 0) 
    		this.msg.innerHTML="Playing...";
      else this.msg.innerHTML="Buffering...";
      this.position = position;
      if(!this.info) { this.info=true; this.getInfo(); }

      var duration = this.sound.getDuration();
      if(!duration) duration = 0;
      if(duration == this.duration && duration != 0) isDurationOk = true;
      //if(duration != 0) isDurationOk = true;

      //$('debug').innerHTML="position="+position+"this.duartion="+this.duration+ "duartion="+duration+ " " +isDurationOk;    

      this.duration = duration;
        //var progress = Math.round((position/duration) * 100);
        //this.setProgressBar(progress);

      if(isDurationOk) {
        var progress = Math.round((position/duration) * 100);
        this.setProgressBar(progress);
	this.time.innerHTML=this.formatTime(position)+'/'+this.formatTime(this.duration);
      }else this.time.innerHTML=this.formatTime(position);

      var bytesTotal = this.sound.getBytesTotal();
      if(bytesTotal == this.bytesTotal) {
        var loaded = Math.round((this.sound.getBytesLoaded()/bytesTotal) * 100);
	if(loaded < 99) this.msg.innerHTML="Loading..."+loaded+"%";
      }
      this.bytesTotal = bytesTotal;
      if (progress > 98 && duration != 0 && position != 0 && isDurationOk) {
    	  if(!this.playList) this.stop();
	  else {
	    if (this.currentTrack == this.list[this.list.length-1]) this.stop();
	    else this.nextTrack();
	  }
      }

   },
   formatTime	: function(msec) {
    var s = msec / 1000;
    var sec = Math.round(s % 60);
    sec = (sec < 10) ? '0'+sec : sec;
     return Math.floor(s/60)+':'+sec;
   },
   setInfoStr	: function() {
	if(this.stoped || this.paused) {
	    clearTimeout(this.tInfo)
	    this.infoDiv.style.marginLeft='1px';
	    return;
	}   
	if(this.infoStr.length) {
	    if(this.infoStrMargin < this.infoStrLeft) this.infoStrMargin=this.pWidth;
	    else this.infoStrMargin-=7;
	    this.infoDiv.style.marginLeft=this.infoStrMargin+'px';
	    this.tInfo=setTimeout(function() {
		       fm.player.setInfoStr();
		    },170);
	}
   
   },
   setProgressBar: function(progress) {
        if(progress < 1) progress=1;
	this.progressBar.style.width = progress + '%';      
   },
   
   registerCallback: function() {
      this.intervalId=setInterval(this.onTimerEvent.bind(this), this.frequency);
   },
   onClickPlayList: function (event) {
	if(!this.divPL) return;
	if(this.divPL.style.display != 'none') {
	    this.hidePL();
	    return;
	}
	new Effect.BlindDown(this.divPL,{duration: 0.5});
	this.plistBtn.src=this.imgdir+'plu_w.gif';
   
   },    
   play: function() {
      if(!this.paused && !this.stoped) return;
      this.paused = false;
      this.stoped = false;
      this.onPlay();
      this.sound.start(this.position/1000, 1);
      //this.intervalId=setInterval(this.onTimerEvent.bind(this), this.frequency);
   },
   onPlay: function() {
      this.playBtn.src =this.imgdir+'play_off.gif';
      this.stopBtn.src =this.imgdir+'stop_on.gif';
      this.pauseBtn.src =this.imgdir+'pause_on.gif';
      this.msg.innerHTML="Playing...";
      this.setInfoStr();
   },
   pause: function() {
      if(this.paused || this.stoped) return;
      this.playBtn.src=this.imgdir+'play_on.gif';
      this.pauseBtn.src =this.imgdir+'pause_off.gif';
      this.msg.innerHTML="Paused...";
      this.paused = true;
      this.position = this.sound.getPosition();
      this.sound.stop();         
   },
   stop: function() {
       if(this.stoped) return;
       this.paused = true;
       this.stoped = true;
       this.position = 0;
       this.duration = 0;
       this.sound.start(this.duration/1000, 1);
       this.sound.stop();         
       this.setProgressBar(0);
       this.playBtn.src =this.imgdir+'play_on.gif';
       this.stopBtn.src=this.imgdir+'stop_off.gif';
       this.pauseBtn.src =this.imgdir+'pause_off.gif';
       this.msg.innerHTML="Stoped...";
       this.time.innerHTML="";
       //clearInterval(this.intervalId);
   },   
   nextTrack: function () {
	if(!this.playList) return;
	var i = this.list.indexOf(this.currentTrack) + 1;
	if(this.list.length == i) i = 0;
	this.loadTrack(this.list[i]);
   },
   prevTrack: function() {
	if(!this.playList) return;
	var i = this.list.indexOf(this.currentTrack) - 1;
	if(i == -1) i = this.list.length - 1;
	this.loadTrack(this.list[i]);
   },
   loadTrack: function(file) {
   	this.position = this.duration = this.bytesTotal = 0;
   	this.stop();
	this.sound.loadSound('lib/loadfile.php?file='+encodeURIComponent(file)+'&type=mp3',true);
	this.paused = false;
	this.stoped = false;
	this.info = false;
	this.infoStr='';
	this.infoDiv.innerHTML='&nbsp;';
	this.display.innerHTML="&nbsp;File: "+file.substr(file.lastIndexOf('/')+1)+"<br>";
	
	if(this.playList) {
	    $(this.currentTrack+'-track').style.backgroundColor='#92b8d8';
	    $(this.currentTrack+'-track').style.color='#000';
	    $(file+'-track').style.backgroundColor='#34548f';
	    $(file+'-track').style.color='#fff';
	}
	this.currentTrack=file;
	this.setProgressBar(0);
	this.onPlay();
   },
   onMouseOver: function(id,action) {
	if(action == 'stop' && this.stoped) return;
	if(action == 'pause' && this.paused) return;
	if(action == 'play' && !(this.stoped || this.paused)) return;
	if((action == 'next' || action == 'prev') && !this.playList) return;
        id.src =this.imgdir+action+'_hl.gif';
   },
   onMouseOut: function(id,action) {
      	if(action == 'stop' && this.stoped) return;
	if(action == 'pause' && this.paused) return;
	if(action == 'play' && !(this.stoped || this.paused)) return;
	if((action == 'next' || action == 'prev') && !this.playList) return;
        id.src =this.imgdir+action+'_on.gif';
   },
   load: function(list) {

	this.list = list;
	this.playList = (list.length > 1) ? true:false;
	if(!this.playList) {
	    this.nextBtn.src=this.imgdir+'next_off.gif';
	    this.prevBtn.src=this.imgdir+'prev_off.gif';
	} else {
	    this.nextBtn.src.src=this.imgdir+'next_on.gif';
	    this.prevBtn.src=this.imgdir+'prev_on.gif';
	}
	var file = this.currentTrack = list[0];
	if(!this.playList) this.plistBtn.style.display='none';
	else {
	    this.plistBtn.style.display='';
	    var html="<ul width='98%' style='cursor: hand;list-style-type: none; margin: 1px; padding: 1px;'>";
	    for (var f,i = 0; i < list.length ; i++) {
		   f=list[i].substr(list[i].lastIndexOf('/')+1);
		   html+="<li id='"+list[i]+"-track' height='18' onmouseover='if(fm.player.currentTrack != \""+list[i]+"\") this.style.backgroundColor=\"#6094c4\";'"+
		   "onmouseout='if(fm.player.currentTrack != \""+list[i]+"\") this.style.backgroundColor=\"#92b8d8\";'"+
		   "onclick='fm.player.loadTrack(\""+list[i]+"\");'>";
		   if(list.length < 10) html+="&nbsp;";
		   html+="&nbsp;"+(i+1)+".&nbsp;&nbsp;"+f+"</li>";
	    }
	    html+="</ul>";
	    this.divPL.innerHTML=html;
	}
	this.hidePL();
	this.loadTrack(list[0]);

   },

   getInfo: function() {
	var str = '';
	var s = this.sound.getId3();
    	var i='';
	if(s) {
	    if(s.album) {
		str=s.album.strip(); if(str) i+="&nbsp;Album: "+str+"&nbsp;";
	    }
	    if(s.year) {
		str=s.year.strip(); if(str && str != 'null') i+=str;
	    }
	    if(s.artist) {
		str=s.artist.strip().stripTags(); if(str) i+="&nbsp;Artist: "+str;
	    }
	    if(s.songname) {
		str=s.songname.strip(); if(str) i+="&nbsp;Song: "+str;
	    }
	    if(i.length > 10) {
		
		this.infoStr=i;
		this.infoDiv.style.width=(i.length * 7) + 'px';
		this.infoStrLeft=this.pWidth - (i.length * 7);
		this.infoDiv.style.marginLeft=this.pWidth+'px';
		this.infoDiv.innerHTML=i;
		this.setInfoStr();
	    }
	}
	
    
   },

   hide: function() {
	this.sound.stop();
	this.player.hide();
   },
   hidePL: function() {
	if(this.divPL) {
	    new Effect.BlindUp(this.divPL,{duration: 0.5});
	    this.plistBtn.src=this.imgdir+'pld_w.gif';
	}
	
   }
}