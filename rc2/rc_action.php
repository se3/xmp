<? 
error_reporting(0);

if ($_POST['power']){
	exec("echo -n O > /tmp/ir");
}else if ($_POST['subt']){
	exec("echo -n '!s ' > /tmp/ir");

}else if ($_POST['home']){
	exec("echo -n '!' > /tmp/ir");
}else if ($_POST['1']){
	exec("echo -n a > /tmp/ir");
}else if ($_POST['2']){
	exec("echo -n e > /tmp/ir");
}else if ($_POST['3']){
	exec("echo -n d > /tmp/ir");
}else if ($_POST['4']){
	exec("echo -n z > /tmp/ir");
}else if ($_POST['5']){
	exec("echo -n g > /tmp/ir");
}else if ($_POST['6']){
	exec("echo -n m > /tmp/ir");
}else if ($_POST['7']){
	exec("echo -n s > /tmp/ir");
}else if ($_POST['8']){
	exec("echo -n f > /tmp/ir");
}else if ($_POST['9']){
	exec("echo -n t > /tmp/ir");
}else if ($_POST['info']){
	exec("echo -n i > /tmp/ir");
}else if ($_POST['0']){
	exec("echo -n v > /tmp/ir");
}else if ($_POST['return']){
	exec("echo -n r > /tmp/ir");
}else if ($_POST['up']){
	exec("echo -n k > /tmp/ir");
}else if ($_POST['left']){
	exec("echo -n h > /tmp/ir");
}else if ($_POST['enter']){
	exec("echo -n ' ' > /tmp/ir");
}else if ($_POST['right']){
	exec("echo -n l > /tmp/ir");
}else if ($_POST['down']){
	exec("echo -n j > /tmp/ir");


}else if ($_POST['play_pause']){
	exec("echo -n p > /tmp/ir");
}else if ($_POST['stop']){
	exec("echo -n S > /tmp/ir");
}else if ($_POST['pgup']){
	exec("echo -n '{' > /tmp/ir");
}else if ($_POST['pgdn']){
	exec("echo -n '}' > /tmp/ir");

}else if ($_POST['FF']){
	exec("echo -n '>' > /tmp/ir");
}else if ($_POST['FB']){
	exec("echo -n '<' > /tmp/ir");

}else if ($_POST['vol_up']){
	exec("echo -n '+' > /tmp/ir");
}else if ($_POST['vol_down']){
	exec("echo -n '-' > /tmp/ir");

}else if ($_POST['audio']){
	exec("echo -n A > /tmp/ir");
}else if ($_POST['a-b']){
	exec("echo -n '@' > /tmp/ir");
}else if ($_POST['repeat']){
	exec("echo -n '&' > /tmp/ir");


}else if ($_POST['shufl']){
	exec('echo -n u > /tmp/ir');
}else if ($_POST['mute']){
	exec("echo -n M > /tmp/ir");
}else if ($_POST['subtitle']){
	exec("echo -n T > /tmp/ir");
}else if ($_POST['sync_left']){
	exec("echo -n '.' > /tmp/ir");
}else if ($_POST['sync_right']){
	exec("echo -n '/' > /tmp/ir");

}else if ($_POST['search']){
	$command=$_POST['command'];
	$fp=fopen('/tmp/netkey.data', 'w');
	fwrite($fp, $command);
	fclose($fp);
	exec("echo -n r > /tmp/ir");

}
?>