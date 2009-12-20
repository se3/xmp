<?
class fakeShell {

     var $configitems;
     var $configpath;
     
	var $version;
	var $uname;
	var $path;
	var $webpad;

	function fakeShell() {

		$this->version = "bassed on v1.0.5.1 modified for backup";

		chdir("../");
		$this->uname = $this->getLinux();
		$this->path = $this->getPath();
		
		$this->configpath = $this->path ."/backup/";
		$this->configfile = $this->configpath.'configfiles.txt';
		$this->webpad = $this->path.'webpad';

           $this->configitems = explode("\n", file_get_contents($this->configfile) );
		//$this->configitems = array(  "/usr/local/daemon/samba/lib/smb.conf", "/root/transmission/settings.json", "/sbin/www/stupid-ftpd.conf", "/sbin/www/ushare.conf"  );

		$this->pasteHeader();
		
		print '<table><tr><td valign=top>';
		$this->pasteTabs();
		print '</td><td valign=top>';		
      	$this->pasteShell();
		print '</td></tr></table>';
      	
		$this->pasteFooter();
	}

	function getLinux() {
		@exec("uname -a", $uname);
		return $uname[0];
	}

	function getPath() {
		@exec("pwd", $path);
		return $path[0];
	}

	function pasteHeader() {
		print '<html>';
		print '<head>';
		print '<title>mavvy\'s fakeshell '.$this->version.'</title>';
		print '<link rel="stylesheet" type="text/css" href="backup.css">';
		print '</head>';
		print '<body>';
	}

	function pasteFooter() {
		print '</body>';
		print '</html>';
	}

	function pasteTabs() {
		print '<div id="tabs">';
		print '<a href="#" onclick="document.location.href = \''. $this->webpad .'?t=server&f='.$this->configfile .'\'";">edit configuration file</a><br><br>';

		foreach ($this->configitems as $configitem ) {
		     $configitem = rtrim($configitem);
		     print '<ul>';
			print '<li><a href="#" onclick="document.shell.cmd.value=\'cp '.$configitem.' '.$this->configpath.' | ls -l '.$this->configpath.'\';document.shell.cmd.focus();">save</a></li>';
			print '<li><a href="#" onclick="document.shell.cmd.value=\' cp '.$this->configpath . basename($configitem).' '.$configitem.' | ls -l '.$this->configpath.'\';document.shell.cmd.focus();">restore</a></li>';
			print '<li><a href="#" onclick="document.location.href = \''. $this->webpad .'?t=server&f='.$this->configpath . basename($configitem).'\' ";">edit backup</a></li>';
			print '<li><a href="#" onclick="document.location.href = \''. $this->webpad .'?t=server&f='.$configitem .'\'";">edit local</a></li>';
		     print ' '.basename($configitem).'</ul>';
		}
		print '</div>';
	}
	
	
	function pasteShell() {
		print '<div id="shell">';
		print '<form name=shell method=post action="'. $PHP_SELF .'">';
 
		print '# <input type=text name=cmd size=110 value="';

		if(isset($_POST[cmd])) {
			print $_POST[cmd];
		}

		print '"><script> document.shell.cmd.focus(); </script></pre>';
		print '<pre>';

		if (!empty($_POST[cmd])) {
			system($_POST[cmd]);
		}

		print '</form>';
		print '</div>';
	}

	function stripSpaces($string) {
		while (strstr($string, "  ")) {
			$string = str_replace("  ", " ", $string);
		}
		return $string;
	}

}

$fakeshell = new fakeShell();
?>
