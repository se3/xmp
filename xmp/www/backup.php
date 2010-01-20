<style type="text/css">

th, td {
text-align: right;
padding: 3px 2px 5px;
}

table a {
text-decoration: none;
padding: 2px 4px;
font-family: Arial, Helvetica, sans-serif;
font-size: 85%;
background: #BBB;
}

</style>

<?
class fakeShell {

     var $configitems;
     var $configpath;
     
	var $version;
	var $uname;
	var $path;
	var $webpad;

	function fakeShell() {

		$this->version = "based on v1.0.5.1 modified for backup";

		$this->uname = $this->getLinux();
		$this->path = $this->getPath();
		
		$this->configpath = $this->path ."/backup/";
		$this->configfile = $this->configpath.'configfiles.txt';
		$this->webpad = 'webpad';

                $this->configitems = explode("\n", file_get_contents($this->configfile) );

		$this->pasteTabs();
         	$this->pasteShell();
	}

	function getLinux() {
		@exec("uname -a", $uname);
		return $uname[0];
	}

	function getPath() {
		@exec("pwd", $path);
		return $path[0];
	}

	function pasteTabs() {
		print '<table><tr><td><a href="#" onclick="document.location.href = \''. $this->webpad .'?t=server&f='.$this->configfile .'\'";">edit configuration file</a></td></tr></table><br />';

		print '<table>';
		foreach ($this->configitems as $configitem ) {
			$configitem = rtrim($configitem);
			print '<tr>';
                        print '<td>'.basename($configitem).'</td>';
			print '<td><a href="#" onclick="document.shell.cmd.value=\'cp '.$configitem.' '.$this->configpath.' | ls -l '.$this->configpath.'\';document.shell.cmd.focus();">save</a></td>';
			print '<td><a href="#" onclick="document.shell.cmd.value=\' cp '.$this->configpath . basename($configitem).' '.$configitem.' | ls -l '.$this->configpath.'\';document.shell.cmd.focus();">restore</a></td>';
			print '<td><a href="#" onclick="document.location.href = \''. $this->webpad .'?t=server&f='.$this->configpath . basename($configitem).'\' ";">edit backup</a></td>';
			print '<td><a href="#" onclick="document.location.href = \''. $this->webpad .'?t=server&f='.$configitem .'\'";">edit local</a></td>';
			print '</tr>';
		}
		print '</table><br />';
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
