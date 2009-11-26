
function post_to_url(path, params, method) 
{
    method = method || "post"; 

	var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);
	form.setAttribute("target", 'gframe');

    for(var key in params) {
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", key);
        hiddenField.setAttribute("value", params[key]);

        form.appendChild(hiddenField);
    }

    document.body.appendChild(form);
    form.submit();
	document.body.removeChild(form);
}


function fShowMainControl()
{
    document.location.href = "main.php";
}

function fPower()
{
	post_to_url('rc_action.php', {'power':'post'}); 
}

function fSubtitles()
{
	post_to_url('rc_action.php', {'subtitle':'post'}); 
}

function fInfo()
{
	post_to_url('rc_action.php', {'info':'post'}); 
}

function fHome()
{
	post_to_url('rc_action.php', {'home':'post'}); 
	
}

function fReturn()
{
	post_to_url('rc_action.php', {'return':'post'});

}

function fSettings()
{
	post_to_url('rc_action.php', {'7':'post'}); 
}

function fLeftarrow()
{
	post_to_url('rc_action.php', {'left':'post'});
}

function fRightarrow()
{
	post_to_url('rc_action.php', {'right':'post'}); 
}

function fToparrow()
{
	post_to_url('rc_action.php', {'up':'post'}); 
}

function fBottomarrow()
{
	post_to_url('rc_action.php', {'down':'post'}); 
}

function fStop()
{
	post_to_url('rc_action.php', {'stop':'post'}); 
}

function fPlay()
{
	post_to_url('rc_action.php', {'play_pause':'post'}); 
}

function fNext()
{
	post_to_url('rc_action.php', {'pgdn':'post'}); 
}

function fPrevious()
{
	post_to_url('rc_action.php', {'pgup':'post'}); 
}

function fRW()
{
	post_to_url('rc_action.php', {'FB':'post'}); 
}

function fFF()
{
	post_to_url('rc_action.php', {'FF':'post'}); 
}


function fVolumminus()
{
	post_to_url('rc_action.php', {'vol_down':'post'}); 
}

function fVolumplus()
{
	post_to_url('rc_action.php', {'vol_up':'post'});  
}

function fGotosub()
{
    document.location.href = "sub.php"; 
}

function fAll()
{
    //redirection to the main panel page
    //if(document.location.href.indexOf("main.html") < 0)
    //{
    //    document.location.href = "main.html";
    //}
	alert('Will support later');
 
}

function fMovies()
{
    //redirection to the main panel page
    //if(document.location.href.indexOf("main.html") < 0)
    //{
    //    document.location.href = "main.html";
    //}
	alert('Will support later');
}

function fMusic()
{
     //redirection to the main panel page
    //if(document.location.href.indexOf("main.html") < 0)
    //{
    //    document.location.href = "main.html";
    //}
	alert('Will support later');
}

function fPictures()
{
     //redirection to the main panel page
    //if(document.location.href.indexOf("main.html") < 0)
    //{
    //    document.location.href = "main.html";
    //}
	alert('Will support later');
}

function fEnter()
{
	post_to_url('rc_action.php', {'enter':'post'});
}

function fShowNowPlaying()
{
    //document.location.href = "nowplaying.html"; 
	alert('Will support later');
}

function fMute()
{
	post_to_url('rc_action.php', {'mute':'post'}); 
}

function fAB()
{
	post_to_url('rc_action.php', {'a-b':'post'}); 
}

function fAudio()
{
	post_to_url('rc_action.php', {'audio':'post'}); 
}

function fShuffle()
{
	post_to_url('rc_action.php', {'shufl':'post'}); 
}

function fRepeat()
{
	post_to_url('rc_action.php', {'repeat':'post'}); 
}

function fSyncplus()
{
	post_to_url('rc_action.php', {'sync_right':'post'}); 
}

function fSyncminus()
{
	post_to_url('rc_action.php', {'sync_left':'post'}); 
}

function fOneAdd()
{
		post_to_url('rc_action.php', {'1':'post'}); 
}

function fTwoEject()
{
		post_to_url('rc_action.php', {'2':'post'});
}

function fThreeDelete()
{
		post_to_url('rc_action.php', {'3':'post'});
}

function fFourZoom()
{
		post_to_url('rc_action.php', {'4':'post'});
}

function fFiveGoto()
{
		post_to_url('rc_action.php', {'5':'post'});
}

function fSixMenu()
{
		post_to_url('rc_action.php', {'6':'post'});
}

function fNineTvout()
{
		post_to_url('rc_action.php', {'9':'post'});
}

function fEightFunc()
{
		post_to_url('rc_action.php', {'8':'post'});
}

function fSevenSetup()
{
		post_to_url('rc_action.php', {'7':'post'});
}

function fZeroPreview()
{
		post_to_url('rc_action.php', {'0':'post'});
}

function fSearch()
{
    var q = document.getElementById("searchtext").value;
	post_to_url('rc_action.php', {'command' :q});
}
