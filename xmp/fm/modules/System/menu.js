fm.addRightToolBar('system',Array('<?=$strShell?>','sys.run()','true','sys_off.gif','sys_on.gif'));
sys.tDir='<?=array_shift(array_values($filemanager_dirs))?>';
sys.user='<?=get_current_user()?>';
sys.strClear='<?=$strClearScreen?>';