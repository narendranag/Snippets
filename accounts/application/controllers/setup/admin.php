<?php

class Admin extends Application
{
	function Admin()
	{
		parent::Application();
	}
	
	function index()
	{
		if($this->auth->logged_in())
		{
			echo anchor("setup/admin/register_new_user", "Register New User");
		}
		else
		{
			echo("This is the client section.");
			$this->auth->login();
		}
	}
	
	function admin_area()
	{
		// This is only accessible to admins
		$this->auth->restrict('admin');
		//echo("admin area");
	}
	
	function editor_area()
	{
		// This is accessible to editors and admins
		$this->auth->restrict('editor');
		echo("editor area");
	}
	
	function user_area()
	{
		// This is accessible to all users
		$this->auth->restrict('user');
		echo("user area");
	}
	
	function users_area()
	{
		// This is accessible to all users too
		$this->auth->restrict();
		echo("user area");
	}
	
	function register_new_user()
	{
		$this->auth->register();
	}
}

?>