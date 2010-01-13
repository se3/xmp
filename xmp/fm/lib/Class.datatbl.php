<?php
class DataTbl {
    var $id;
    var $width = "100%";
    var $els = array();
    var $border;
    var $style;
    var $className;
    var $cellpadding;
    var $cellspacing;
    var $cols;
    var $required = array();
    var $filters = array();

    function DataTbl($width="100%",$border=0,$cellpadding=0,$cellspacing=5,$style="",$className="") {
	if($width) $this->width=" width=\"$width\" ";
	else $this->width=" width=\"100%\" ";
	$this->style=$style;
	$this->className=$className;
	if($border) $this->border=" border=\"$border\" ";
	$this->cellpadding=$cellpadding;
	$this->cellspacing=$cellspacing;
	$this->id=uniqid(true);
    }
    function setCols($cols) {
	$this->cols=$cols;
    }
    function addFilter($id,$filter,$options="") {
	global $strFieldMustBeInteger,$strFieldMustBeFloat,$strFieldMustNotContainSym,$strFieldMustBeValidEmail;
	    $arr = array();
	    $arr['type']=$filter;
	    $arr['id']=$id;
	    if($filter=="integer") $arr['msg']=$strFieldMustBeInteger;
	    elseif($filter=="float") $arr['msg']=$strFieldMustBeFloat;
	    elseif($filter=="email") $arr['msg']=$strFieldMustBeValidEmail;
	    elseif($filter=="symbols" && $options) {
	        $opt="Array(";
		$sym=" ";
		foreach($options as $s) {
		    $opt.="'".addslashes($s)."',";
		    $sym.="'".$s."',";
		}
		$opt[strlen($opt)-1]=")";
		$sym[strlen($sym)-1]=" ";
		$arr['options']=$opt;
		$arr['msg']=addslashes(htmlspecialchars("$strFieldMustNotContainSym ".$sym));
		
	    }
	    
	    array_push($this->filters,$arr);
	        
    }
    function addElement($id,$type,$label,$tr,$val,$style="",$className="",$acl=2) {
	if(empty($tr)) $tr=1;
        if($type=="time") $el = new DT_Time($this,$id,$label,$val,$style,$className,$acl);
	elseif ($type=="button") $el = new DT_Button($this,$id,$label,$val,$style,$className,$acl);
	elseif($type=="select") $el = new DT_Select($this,$id,$label,$val,$style,$className,$acl);
	elseif($type=="checkbox") $el = new DT_Checkbox($this,$id,$label,$val,$style,$className,$acl);
	elseif($type=="textarea") $el = new DT_Textarea($this,$id,$label,$val,$style,$className,$acl);
	elseif($type=="simple") $el = new DT_Simple($this,$id,$label,$val,$style,$classsName,$acl);
	else $el = new DT_Text($this,$id,$label,$val,$style,$className,$acl);
	if(empty($this->els[$tr])) $this->els[$tr]=array();
	array_push($this->els[$tr],$el); 
	$this->el[$id]=$el;
	return $el;
    }
    function show() {
	if($this->style) $style=" style=\"".$this->style."\" ";
	if($this->className) $cls=" class=\"".$this->className."\" ";
	else $cls=" class=\"input-data-tbl\" ";
	echo "<table ".$this->border.$this->width.$style." name=\"$this->id\" id=\"$this->id\" cellpadding=\"$this->cellpadding\" cellspacing=\"$this->cellspacing\" $cls>";	    

	foreach ($this->els as $els) {
	    echo "<tr>";
	    foreach($els as $el) { $el->show(); }
	    echo "</tr>";
	}
	if($this->cols) { 
	    echo "<tr height=1>";
	    foreach($this->cols as $col) {    
		if($col) echo "<td width=\"$col\"></td>";
		else echo "<td></td>";
	    }
	    echo "</tr>";	   
	} 
	
	echo "</table>";
    }
}

class DT_Element {
    var $id="";
    var $name;
    var $type;
    var $colspan="";
    var $rowspan="";
    var $label;
    var $val;
    var $style="";
    var $className="";
    var $align1="";
    var $align2="";
    var $valign1="";
    var $valign2="";
    var $width1="";
    var $width2="";
    var $acl;
    var $tbl;
    var $hc=1;

    function DT_Element ($tbl,$id,$label,$val,$style="",$className="",$acl=2) {
	$this->tbl=$tbl;
	$this->id=$id;
	if($id) $this->name=" name=\"".$id."\" id=\"".$id."\" ";
	$this->label=$label;
	$this->val=$val;
	if($style) $this->style=" style=\"$style\" ";
	if($className) $this->className=" class=\"$className\" ";
	$this->acl=$acl;
    }

    function show($required=false) {
    	if($this->colspan) $cs=" colspan=\"".$this->colspan."\"";	
	if($this->rowspan) $rs=" rowspan=\"".$this->rowspan."\"";	
	if($this->align1)  $al1=" align=\"".$this->align1."\"";	
	if($this->align2)  $al2=" align=\"".$this->align2."\"";	
	if($this->valign1) $val1=" valign=\"".$this->valign1."\"";	
	if($this->valign2) $val2=" valign=\"".$this->valign2."\"";	
	if($this->width1)  $w1=" width=\"".$this->width1."\"";	
	if($this->width2)  $w2=" width=\"".$this->width2."\"";	
    	//echo "<td $al1 nowrap valign=\"top\">";
	echo "<td".$al1.$val1.$w1.$this->style." nowrap=\"nowrap\">";
	if($required) echo "<font color=\"red\">*</font>&nbsp;";
	else echo "&nbsp;&nbsp;";
	if($this->hc) echo htmlspecialchars($this->label)."</td>";
	else echo $this->label."</td>";
	echo "<td".$al2.$val2.$cs.$rs.$w2.$this->style." nowrap=\"nowrap\">";    
	
    }
}

class DT_Simple extends DT_Element {

    function show () {
    	if($this->id) $id=" id=\"".$this->id."\"";	
    	if($this->colspan) $cs=" colspan=\"".$this->colspan."\"";	
	if($this->rowspan) $rs=" rowspan=\"".$this->rowspan."\"";	
	if($this->align2) $al=" align=\"".$this->align2."\"";	
	if($this->width2) $w=" width=\"".$this->width2."\"";	
	echo "<td".$id.$al.$cs.$rs.$w.$this->style." nowrap>";
	if($this->hc) echo htmlspecialchars($this->val)."</td>";
	else echo $this->val."</td>";
    }

}

class DT_Button extends DT_Element {
    var $action="";
    var $check_input=true;
    var $submit = true;
    var $img="";
    function setOptions($action,$submit=true,$img="") {
	$this->action=$action;
	$this->submit=$submit;
	$this->img=$img;
    }
    function show () {
	global $action,$current_module;
	 
	if(empty($this->action)) $this->action="$('current_page').value=0;loadModule(1,'$current_module','$current_module','$action')";
	if($this->submit) {
	    
	    if(!empty($this->tbl->required)) {
		$req="Array(";
		foreach($this->tbl->required as $r) {  $req.="'".$r."',"; }
		$req{strlen($req)-1}=")";
	    }
	    if(!empty($this->tbl->filters)) {
		echo "<script type=\"text/javascript\">  __aRr__ = new Array();";
		$i=0;
		foreach($this->tbl->filters as $f) {
		    echo "__aRr__[$i]= {}; __aRr__[$i]['type']='".$f['type']."';";
		    echo "__aRr__[$i]['id']='".$f['id']."';__aRr__[$i]['msg']='".$f['msg']."';";
		    if($f['type'] == "symbols") echo "__aRr__[$i]['options']=".$f['options'].";";
		    $i++;
		}
		echo "</script>"; $filters="__aRr__";
	    }	
	    if($req || $filters) {
		if(!isset($req)) $req="0"; if(!isset($filters)) $filters="0";	
		$this->action="if(!fm.checkInputs($req,$filters)) return false;".$this->action;
		//echo $this->action;
	    }
	}
	if($this->align2) $al=" align=\"".$this->align2."\"";	
	if($this->width2) $w=" width=\"".$this->width2."\"";	
	if($this->valign2) $val=" valign=\"".$this->valign2."\"";	
	if($this->colspan) $cs=" colspan=\"".$this->colspan."\"";	
	if($this->rowspan) $rs=" rowspan=\"".$this->rowspan."\"";	
	if($this->className) $cls=$this->className;
	else $cls="class=\"sbutton\"";
	//echo "style=".$this->style;
	if($this->img) echo "<td".$cs.$al.$val.$w.$rs.$this->style."><a href=\"javascript:void(0)\"".$this->name."onclick=\"".$this->action."\">".$this->img."</a></td>";
	else echo "<td".$cs.$al.$val.$w.$rs.$this->style."><input type=\"button\"".$this->name."onclick=\"".$this->action."\" value=\"".$this->val."\" $cls /></td>";
    }

}
class DT_Text extends DT_Element {
    var $size=15;
    var $autofill_id;
    var $autofill_url;
    var $maxlength;
    var $readonly=false;
    var $required=false;
    var $custom;
    var $action="";
    var $symbols=array("'","\"","<",">","\\","?");
    
    function setOptions($size=15,$required=false,$maxlength=80,$filter="",$autofill_url="") {
	//global $strFieldMustBeInteger,$strFieldMustBeFloat,$strFieldMustNotContainSym,$strFieldMustBeValidEmail;
	if($size) $this->size=$size; else $this->size=15;
	$this->required=$required;
	if(!$maxlength) $maxlength=80;
	$this->maxlength=" maxlength=\"$maxlength\" ";
	if($required) array_push($this->tbl->required,$this->id);
	if($filter) $this->tbl->addFilter($this->id,$filter,$this->symbols);

	$this->autofill_id=$autofill_id;
	$this->autofill_url=$autofill_url;
    }
    function show () {
	parent::show($this->required);
	if($this->readonly) $ro=" readonly=1 "; else $ro="";
	if($this->type) $type=" type=\"".$this->type."\" ";
	else $type=" type=\"text\" ";
	echo "<input ".$type.$this->name.$this->action." size=\"".$this->size."\" value=\"".htmlspecialchars($this->val)."\" ".$this->maxlength.$this->className.$ro." autocomplete=\"off\" />";
	if($this->autofill_url) {
	    $id=uniqid(true);
	    echo "<div align=\"left\" id=\"".$id."\" style=\"display:none; border: 1px solid black; background-color: white;\">";
	    echo "</div></td>";
	    echo "<script type=\"text/javascript\">";
    	    echo " new Ajax.Autocompleter('".$this->id."','".$id."','".$this->autofill_url."');";
	    echo "</script>";
	}
	echo "</td>";
    }

}
class DT_Time extends DT_Element {
    var $size=15;
    var $iformat;
    var $onupdate;
    var $showOthers;
    var $showsTime;
    function setOptions ($size="",$iformat="",$showOthers=true,$onupdate="",$showsTime=true) {
	if($size) $this->size=$size; else $size=15;
	if($iformat) $this->iformat=$iformat;
	else $iformat="";
	$this->onupdate= $onupdate ? ",onUpdate : ".$onupdate : "";
	$this->showOthers=$showOthers ? "true" : "false";
	$this->showsTime= $showsTime ? "true" : "false";
    
    }
    function show () {
	$btn_id=uniqid(true);
	parent::show();
	echo "<input type=\"text\" ".$this->name." size=\"".$this->size."\" value=\"".$this->val."\"  readonly=\"1\" autocomplete=\"0\" />";
	echo " <img align=\"absmiddle\" id=\"$btn_id\" src=\"images/jscalendar.gif\" 
	      title=\"".$this->label."\" /></td>";
	echo "<script type=\"text/javascript\">";
	echo "Calendar.setup({
		inputField	: \"".$this->id."\",
		ifFormat	: \"".$this->iformat."\",
		showsTime	: ".$this->showsTime.",
		timeFormat	: \"24\",
		button		: \"$btn_id\",
		align		: \"Br\",
		firstDay	: 1,
		showOthers	: true,
		singleClick	: true
		".$this->onupdate."

		});</script>";

    }

}
class DT_Checkbox extends DT_Element {
    function show () {
	parent::show("",$this->collapse);
	if($this->val) $check=" checked ";
	if($this->className) $cls=$this->className;
	else $cls="class=\"checkbox\"";
	echo "<input type=\"checkbox\"".$this->name."$check $cls style='border: 0; margin: 0;'/></td>";
    }
}
class DT_Textarea extends DT_Element {
    var $cols=20;
    var $rows=5;
    var $readonly=false;
    var $symbols=array("'","\"","<",">","\\","?");

    function setOptions($cols,$rows=5,$filter="") {
	$this->cols=$cols;
	$this->rows=$rows;
	if($filter) $this->tbl->addFilter($this->id,$filter,$this->symbols);

    }
    function show () {
	parent::show();
	echo "<textarea ".$this->name." cols=\"".$this->cols."\" rows=\"".$this->rows."\"".$this->className.">";
	echo htmlspecialchars($this->val)."</textarea></td>";
    }
}
class DT_Select extends DT_Element {
    var $options;
    var $type;
    var $key=true;
    var $cur;
//    var $fixperiod=array();
    var $action;

    function show () {
	parent::show();
	if($this->action) $action=" onchange=\"".$this->action."\" ";
	//echo "val=".$this->val;
	echo "<select".$this->name." $action>"; 
	if($this->type=="lang") $this->lang();
	elseif ($this->type=="currency") $options=$this->currency();
    	elseif ($this->type=="theme") $options=$this->theme();
	elseif ($this->type=="dateformat") $options=$this->dateformat();
//	elseif ($type=="fixperiod") $options=$this->fixperiod();
	else {
	    foreach($this->options as $key => $val) {
		//if($this->key) $val=$k; else $val=$v;
		if($key == $this->val) $s = "selected"; else $s="";
		echo "<option $s value=\"$key\">$val</option>";
	    }
	}
	echo "</select></td>";
    }
    function lang () {
	global $languages;
	echo "val=".$this->val;
	foreach($languages as $key=>$value) {
	    if($key == $this->val) $s="selected"; else $s="";
	    echo "<option $s value=\"$key\">$value</option>";	
	}
    }
    function theme () {
	foreach(glob("themes/*") as $th) {
	    $t=basename($th);
	    if($t == $this->val) $s=" selected "; else $s="";
	    echo "<option $s value=\"$t\">$t</option>";
	}
    }
    function currency () {
	global $default_currency;
	if(!$this->cur) $cur = new Currencies();
	else $cur = $this->cur;
	$cur->get_list();
	$list = $cur->list_currencies;
	if(empty($list)) echo "<option value=\"$default_currency\">$default_currency</option>";
	else {
	    foreach($list as $c) {
		if($c[8] == $this->val) $s = "selected"; else $s="";
		echo "<option $s value=\"".$c[8]."\">".$c[1]."</option>";
	    }
	}    
    }
    function dateformat() {
	global $dateformats;
	foreach($dateformats as $df) {
	    if($this->val == $df) $s="selected"; else $s="";
	    echo "<option $s value=\"$df\">$df</option>";
	}
    }

}	

?>



