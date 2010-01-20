<style type="text/css">

th, td {
padding: 0px;
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

	var $version;
	var $uname;
	var $path;
	var $menu;
	var $area;

	function fakeShell() {

		$this->version = "1.0.5.1";
		$this->uname = $this->getLinux();
		$this->path = $this->getPath();
            
		$this->menu['clear'] = "";
		$this->menu['telnetd'] = $this->path."/busybox telnetd -l /bin/sh &";
		$this->menu['processes'] = "ps aux";

		$this->area = $_GET['area'];

		$this->pasteTabs();

		switch ($this->area) {
			case 'diskinfo':
				$this->pasteDiskInfo();
				break;
			default:
				$this->pasteShell();
				break;
		}
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
		print '<table>';
		switch ($this->area) {
			case 'diskinfo':
				print '<tr><td><a href="?page=fakeshell.php&area=shell" style="padding-left:5px;">shell</a></td></tr>';
				break;
			default:
				print '<tr>';
				foreach ($this->menu as $k => $v) {
					print '<td><a href="#" onclick="document.shell.cmd.value=\''.$v.'\';document.shell.cmd.focus();">'.$k.'</a></td>';
				}
				print '<td><a href="#" onclick="document.shell.cmd.value=\'sleep \'+prompt(\'Shutdown Xtreamer after how many minutes?\')*60+\' && echo -n O > /tmp/ir\';document.shell.cmd.focus();">SLEEP</a></td>';
				print '<td><a href="#" onclick="document.shell.cmd.value=\'reboot\';document.shell.cmd.focus();">REBOOT</a></td>';
				print '<td><a href="?page=fakeshell.php&area=diskinfo">diskinfo</a></td>';
				print '</tr>';
				break;
		}

		print '</table><br />';
	}

	function pasteShell() {
		print '<div id="shell">';
		print '<form name=shell method=post action="'.$PHP_SELF.'">';

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

	function pasteDiskInfo() {

		print '<div id="diskinfo">';

		@exec("df -h", $df);

		foreach ($df AS $k => $v) {
			if (strstr($v, "/tmp/usbmounts/")) {
				$line[$k] = $this->stripSpaces($v);
			}
		}

		foreach ($line AS $k => $v) {
			$token = explode(" ", $v);
			$disk_name[$k] = str_replace("/tmp/usbmounts/", "", $token[5]);
			$disk_total[$k] = $token[1];
			$disk_used[$k] = $token[4];
			$disk_free[$k] = $token[3];
		}

		print '<table width="300" cellspacing="0" cellpadding="0" border="0">';
		print '<tr>';
		print '<td>DISK</td>';
		print '<td>TOTAL</td>';
		print '<td>FREE</td>';
		print '</tr>';
		print '<tr>';
		print '<td colspan="3" height="10"></td>';
		print '</tr>';

		foreach ($disk_name AS $k => $v) {
			print '<tr>';
			print '<td width="100">'.$disk_name[$k].'</td>';
			print '<td width="100">'.$disk_total[$k].'</td>';
			print '<td>'.$disk_free[$k].'</td>';
			print '</tr>';
			print '<tr>';
			print '<td colspan="3" height="10" style="background-color:#800000;"><div style="background-color:#008000;width:'.((int)$disk_used[$k]*3).'px;height:10px;"></div></td>';
			print '</tr>';
			print '<tr>';
			print '<td colspan="3" height="10"></td>';
			print '</tr>';
		}
		print '</table>';

		print '</div>';
	}
}

$fakeshell = new fakeShell();
?>
