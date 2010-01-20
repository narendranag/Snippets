<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends DataMapper {
	
	var $has_many = array("transactions");
	
	function Account() {
		parent::DataMapper();
	}
	
}

?>