<?php

class Transaction extends DataMapper {
	
	var $has_one = array("account");
	
	function Transaction() {	
		parent::DataMapper();
	}
}
?>