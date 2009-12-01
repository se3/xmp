<?php
/***************************************************************************\
			===========================
			PHP BLOG API IMPLEMENTATION
			===========================
 This library of PHP code was produced by the work of two people;
 	Beau Lebens
 	Bill Lazar
 
 The intention was to create a set of classes which provide access to the
 APIs of the most common web log systems - Blogger.com and MoveableType.

 They are based on the PHP XML-RPC library which availabled from
 http://xmlrpc.usefulinc.com/ and which is included in this distribution.
 
 This all started when Beau Lebens, the Primary Consultant of Dented Reality
 (probably where you downloaded this) created a set of functions so that
 he could access the Blogger.com API.
 
 Bill Lazar then came along and turned those functions into an OO class,
 making the code more usable, more portable, and more extensible...
 
 Please email the authors directly with comments/feedback/bugs regarding
 this library, and also to share your project with us!
 
 	Beau Lebens: beau@dentedreality.com.au
 	Bill Lazar: bill@billsaysthis.com
 
 Resources/Links;
 ----------------
 Blogger: http://www.blogger.com/
 PHP XML-RPC: http://xmlrpc.usefulinc.com/
 Blogger API: http://plant.blogger/api/
 Get a Blogger AppID: http://plant.blogger.com/api/register.html
 FireStarter Technologies: http://www.firestarter.com.au/
 
 DentedReality: http://www.dentedreality.com.au/
 BillSaysThis: http://www.billsaysthis.com/
 
\***************************************************************************/

require_once(dirname(__FILE__) . '/xmlrpc.php');

class bloggerclient {
	var $appID = 'Dented Reality webpad http://www.dentedreality.com.au/webpad/';
	var $bServer = 'www.blogger.com';  // should not need to change
	var $bPath = '/api/RPC2';  // should not need to change
	var $apiName = 'blogger';
	var $blogClient;
	var $XMLappID;
	var $XMLusername;
	var $XMLpassword;
	
	function bloggerclient($username, $password, $server, $path) {
		$this->XMLappID	   = new ui_xmlrpcval($this->appID, 'string');
		$this->XMLusername = new ui_xmlrpcval($username, 'string');
		$this->XMLpassword = new ui_xmlrpcval($password, 'string');
		
		$this->setServer($server);
		$this->setPath($path);
		
		$this->connect();
		
		return $this;
	}
	
	function setServer($str) {
		$this->bServer = $str;
	}
	
	function setPath($str) {
		$this->bPath = $str;
	}
	
	function getUsersBlogs() {
		$r = new ui_xmlrpcmsg($this->apiName . '.getUsersBlogs', array($this->XMLappID, $this->XMLusername, $this->XMLpassword));
		$r = $this->exec($r);
		return $r;
	}
	
	function getUserInfo() {
		$r = new ui_xmlrpcmsg($this->apiName . '.getUserInfo', array($this->XMLappID, $this->XMLusername, $this->XMLpassword));
		$r = $this->exec($r);
		return $r;
	}
	
	function getRecentPosts($blogID, $numPosts) {
		$XMLblogid = new ui_xmlrpcval($blogID, 'string');
		$XMLnumPosts = new ui_xmlrpcval($numPosts, 'int');
		$r = new ui_xmlrpcmsg($this->apiName . '.getRecentPosts', array($this->XMLappID, $XMLblogid, $this->XMLusername, $this->XMLpassword, $XMLnumPosts));
		$r = $this->exec($r);
		return $r;
	}
	
	function getPost($postID) {
		$XMLpostid = new ui_xmlrpcval($postID, 'string');
		$r = new ui_xmlrpcmsg($this->apiName . '.getPost', array($this->XMLappID, $XMLpostid, $this->XMLusername, $this->XMLpassword));
		$r = $this->exec($r);
		return $r;
	}
	
	function newPost($blogID, $textPost, $publish=false) {
		$XMLblogid = new ui_xmlrpcval($blogID, 'string');
		$XMLcontent = new ui_xmlrpcval($textPost, 'string');
		$XMLpublish = new ui_xmlrpcval($publish, 'boolean');
		$r = new ui_xmlrpcmsg($this->apiName . '.newPost', array($this->XMLappID, $XMLblogid, $this->XMLusername, $this->XMLpassword, $XMLcontent, $XMLpublish));
		$r = $this->exec($r);
		return $r;
	}
	
	function editPost($blogID, $textPost, $publish=false) {
		$XMLblogid = new ui_xmlrpcval($blogID, 'string');
		$XMLcontent = new ui_xmlrpcval($textPost, 'string');
		$XMLpublish = new ui_xmlrpcval($publish, 'boolean');
		$r = new ui_xmlrpcmsg($this->apiName . '.editPost', array($this->XMLappID, $XMLblogid, $this->XMLusername, $this->XMLpassword, $XMLcontent, $XMLpublish));
		$r = $this->exec($r);
		return $r;
	}
	
	function deletePost($postID, $publish=false) {
		$XMLpostid = new ui_xmlrpcval($postID, 'string');
		$XMLpublish = new ui_xmlrpcval($publish, 'boolean');
		$r = new ui_xmlrpcmsg($this->apiName . '.deletePost', array($this->XMLappID, $XMLpostid, $this->XMLusername, $this->XMLpassword, $XMLpublish));
		$r = $this->exec($r);
		return $r;
	}
	
	function getTemplate($blogID, $template='main') {
		$XMLblogid = new ui_xmlrpcval($blogID, 'string');
		$XMLtemplate = new ui_xmlrpcval($template, 'string');
		$r = new ui_xmlrpcmsg($this->apiName . '.getTemplate', array($this->XMLappID, $XMLblogid, $this->XMLusername, $this->XMLpassword, $XMLtemplate));
		$r = $this->exec($r);
		return $r;
	}
	
	function setTemplate($blogID, $template='archiveIndex') {
		$XMLblogid = new ui_xmlrpcval($blogID, 'string');
		$XMLtemplate = new ui_xmlrpcval($template, 'string');
		$r = new ui_xmlrpcmsg($this->apiName . '.setTemplate', array($this->XMLappID, $XMLblogid, $this->XMLusername, $this->XMLpassword, $XMLtemplate));
		$r = $this->exec($r);
		return $r;
	}
	
	function connectToBlogger() {
		$this->blogClient = new ui_xmlrpc_client($this->bPath, $this->bServer);
		if(is_object($this->blogClient)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function connect() {
		if (!$this->connectToBlogger()) {
			return false;
		}
		else {
			return true;
		}
	}
	
	function exec($req) {
		$result_struct = $this->blogClient->send($req);
		$r = $this->errTest($result_struct);
		return $r;
	}        
	
	function errTest($result_struct) {
		if (!$result_struct->faultCode()) {
			$values = $result_struct->value();
			$result_array = ui_xmlrpc_decode($values);
			$valid = $this->checkFaultString($result_array);
			if ($valid == true) {
				$r = $result_array;
			}
			else {
				$r = $valid;
			}
		}
		else {
			$r = $result_struct->faultString();
		}
		return $r;
	}
	
	function checkFaultString($bloggerResult) {
		if ($bloggerResult['faultString']) {
			return $bloggerResult['faultString'];
		}
		else if (strpos($bloggerResult, 'java.lang.Exception') !== false) {
			return $bloggerResult;
		}
		else {
			return true;
		}
	}
}

?>