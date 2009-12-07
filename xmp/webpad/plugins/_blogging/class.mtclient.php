<?php

/************************************************
class.mtclient.php   v1.0   5/14/2002
kathryn aaker
kathryn@kathrynaaker.com

a subclass of bloggerclient especially for
movabletype users.

A portion of the source code in this class was developed by Bill Lazar,
http://www.billsaysthis.com.
Reuse of this code for any purpose is granted as long as this notice is
included

the php blogger api implementation is available here:
http://www.dentedreality.com.au/bloggerapi/

information on movabletype's xml-rpc implementation:
http://www.movabletype.org/docs/mtmanual_programmatic.html

**************************************************/

require_once(dirname(__FILE__) . '/class.bloggerclient.php');

class mtclient extends bloggerclient {
	function mtclient($username, $password, $host, $path) {
		$this->bServer =  $host;
		$this->bPath = $path;
		$this->app = new ui_xmlrpcval(null, 'string');
		$this->username = new ui_xmlrpcval($username, 'string');
		$this->password = new ui_xmlrpcval($password, 'string');
		
		$this->bloggerclient($username, $password, $host, $path);
	}
	
	function getRecentPosts($blogID, $numPosts) {
		$XMLblogid = new ui_xmlrpcval($blogID, 'string');
		$XMLnumPosts = new ui_xmlrpcval($numPosts, 'int');
		$r = new ui_xmlrpcmsg('metaWeblog.getRecentPosts', array($XMLblogid, $this->XMLusername, $this->XMLpassword, $XMLnumPosts));
		$r = $this->exec($r);
		return $r;
	}
	
	function getRecentPostTitles($blogID, $numPosts) {
		$XMLblogid = new ui_xmlrpcval($blogID, 'string');
		$XMLnumPosts = new ui_xmlrpcval($numPosts, 'int');
		$r = new ui_xmlrpcmsg('metaWeblog.getRecentPostTitles', array($XMLblogid, $this->XMLusername, $this->XMLpassword, $XMLnumPosts));
		$r = $this->exec($r);
		return $r;
	}
	
	function getPost($postID) {
		$XMLpostid = new ui_xmlrpcval($postID, 'string');
		$r = new ui_xmlrpcmsg('metaWeblog.getPost', array($XMLpostid, $this->XMLusername, $this->XMLpassword));
		$r = $this->exec($r);
		return $r;
	}
	
	function newPost($blogID, $textPost, $textTitle = false, $publish = false) {
		$XMLblogid = new ui_xmlrpcval($blogID, 'string');
		if ($textTitle === false) {
			$XMLcontent = new ui_xmlrpcval($textPost, 'string');
		}
		else {
			$XMLcontent = ui_xmlrpc_encode(array('title'=>$textTitle, 'description'=>$textPost));
		}
		$XMLpublish = new ui_xmlrpcval($publish, 'boolean');
		$r = new ui_xmlrpcmsg('metaWeblog.newPost', array($XMLblogid, $this->XMLusername, $this->XMLpassword, $XMLcontent, $XMLpublish));
		$r = $this->exec($r);
		return $r;
	}
	
	function editPost($blogID, $textPost, $textTitle = false, $publish = false) {
		$XMLblogid = new ui_xmlrpcval($blogID, 'string');
		if ($textTitle === false) {
			$XMLcontent = new ui_xmlrpcval($textPost, 'string');
		}
		else {
			$XMLcontent = ui_xmlrpc_encode(array('title'=>$textTitle, 'description'=>$textPost));
		}
		$XMLpublish = new ui_xmlrpcval($publish, 'boolean');
		$r = new ui_xmlrpcmsg('metaWeblog.editPost', array($XMLblogid, $this->XMLusername, $this->XMLpassword, $XMLcontent, $XMLpublish));
		$r = $this->exec($r);
		return $r;
	}
	
	function getCategoryList($blogID) {
		$XMLblogid = new ui_xmlrpcval($blogID, 'string');
		$r = new ui_xmlrpcmsg('mt.getCategoryList', array($XMLblogid, $this->XMLusername, $this->XMLpassword));
		$r = $this->exec($r);
		return $r;
	}
	
	function getPostCategories($postID) {
		$XMLpostid = new ui_xmlrpcval($postID, 'string');
		$r = new ui_xmlrpcmsg('mt.getPostCategories', array($XMLpostid, $this->XMLusername, $this->XMLpassword));
		$r = $this->exec($r);
		return $r;
	}
	
	function get($blogID) {
		$XMLblogid = new ui_xmlrpcval($blogID, 'string');
		$r = new ui_xmlrpcmsg('mt.getCategoryList', array($XMLblogid, $this->XMLusername, $this->XMLpassword));
		$r = $this->exec($r);
		return $r;
	}
	
	function setPostCategories($postID, $categories) {
		$XMLpostid = new ui_xmlrpcval($postID, 'string');
		$XMLcategories = new ui_xmlrpcval($categories, 'array');
		$r = new ui_xmlrpcmsg('mt.setPostCategories', array($XMLpostid, $this->XMLusername, $this->XMLpassword, $XMLcategories));
		$r = $this->exec($r);
		return $r;
	}
	
	function getSupportedMethods() {
		$r = new ui_ui_xmlrpcmsg('mt.supportedMethods');
		$r = $this->exec($r);
		return $r;
	}
}

?>