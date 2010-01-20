<?php
ob_start();
/**
* Authentication Library
*
* @package Authentication
* @category Libraries
* @author Adam Griffiths
* @link http://dotsevern.com
* @link http://freshpowered.com/docs/index.html
*
* Auth provides a powerful, lightweight and simple interface for user authentication 
*/

class Auth
{
	
	var $CI; // The CI object
	var $config; // The config items
	
	/** 
	* Auth constructor PHP5
	*
	* @access public
	* @param string
	*/
	function __construct($config)
	{
		$this->CI =& get_instance();
		$this->config = $config;
		
		$this->CI->load->database();
		$this->CI->load->helper(array('form', 'url', 'email'));
		$this->CI->load->library('form_validation');
		$this->CI->load->library('session');
		
		$this->CI->lang->load('auth', 'english');
		
		if(!isset($_COOKIE['login_attempts']))
		{
			setcookie("login_attempts", 0, time()+900, '/');
		}
		
		if($this->logged_in()) { $this->_verify_cookie(); }
	} // function __construct()
	
	/** 
	* Auth constructor PHP4 support
	*
	* @access public
	* @param string
	*/
	function Auth($config)
	{
		echo("1111<br>");
		self::__construct($config);
		echo("11112<br>");
	} // function Auth()
	
	/** 
	* Restricts access to a page
	*
	* Takes a user level (e.g. admin, user etc) and restricts access to that user and above.
	* Example, users can access a profile page, but so can admins (who are above users)
	*
	* @access public
	* @param string
	* @return bool
	*/
	function restrict($group = NULL)
	{
		if($group === NULL)
		{
			if($this->CI->session->userdata('logged_in') == TRUE)
			{
				return TRUE;
			}
			else
			{
				show_error($this->CI->lang->line('insufficient_privs'));
			}
		}
		elseif($this->logged_in() == TRUE)
		{
			$level = $this->config['auth_groups'][$group];
			$set_level = $this->CI->session->userdata('group');

			if($set_level <= $level)
			{
				return TRUE;
			}
			else
			{
				show_error($this->CI->lang->line('insufficient_privs'));
			}
		}
		else
		{
			redirect($this->config['auth_login'], 'refresh');
		}
	} // function restrict()
	
	
	/** 
	* Log a user in
	*
	* Log a user in a redirect them to a page specified in the $redirect variable
	*
	* @access public
	* @param string
	*/
	function login($redirect = NULL)
	{
		$this->CI->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[40]|callback_username_check');
		$this->CI->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[12]');
		$this->CI->form_validation->set_rules('remember', 'Remember Me');

		if($this->CI->form_validation->run() == FALSE)
		{
			if((array_key_exists('login_attempts', $_COOKIE)) && ($_COOKIE['login_attempts'] >= 5))
			{
				echo $this->CI->lang->line('max_login_attempts_error');
			}
			else
			{
				$this->CI->load->view('auth/login');
			}
		}
		else
		{
			$username = set_value('username');
			$auth_type = $this->_auth_type($username);
			$password = $this->_salt(set_value('password'));
			$email = set_value('email');
			
			if(!$this->_verify_details($auth_type, $username, $password))
			{
				show_error($this->CI->lang->line('login_details_error'));
			}
			
			$userdata = $this->CI->db->query("SELECT * FROM `users` WHERE `$auth_type` = '$username'");
			$row = $userdata->row_array();
			
			$data = array(
						$auth_type => $username,
						'username' => $row['username'],
						'user_id' => $row['id'],
						'group' => $row['group_id'],
						'logged_in' => TRUE
						);
			$this->CI->session->set_userdata($data);
			
			$this->_generate();
			
			redirect($redirect);
		}
	} // function login()
	
	
	/** 
	* Logout - logs a user out
	*
	* @access public
	*/
	function logout()
	{
		$this->CI->session->sess_destroy();
		$this->CI->load->view('auth/logout');
	} // function logout()
	
	
	/** 
	* Register a new user
	*
	* Register a user and redirect them to the success page
	*
	* @access public
	* @param string
	*/
	function register()
	{
		$this->CI->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[40]|callback_reg_username_check');
		$this->CI->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[12]|matches[conf_password]');
		$this->CI->form_validation->set_rules('conf_password', 'Password confirmation', 'trim|required|min_length[4]|max_length[12]|matches[password]');
		$this->CI->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_reg_email_check');
		
		if($this->CI->form_validation->run() == FALSE)
		{
			$this->CI->load->view('auth/register');
		}
		else
		{
			
			$username = set_value('username');
			$password = $this->_salt(set_value('password'));
			$email = set_value('email');
			
			$this->CI->db->query("INSERT INTO `users` (username, email, password) VALUES ('$username', '$email', '$password')");
			
			$userdata = $this->CI->db->query("SELECT * FROM `users` WHERE `username` = '$username'");
			$row = $userdata->row_array();
			
			$data = array(
						'username' => $username,
						'user_id' => $row['id'],
						'group' => $row['group_id'],
						'logged_in' => TRUE
						);
			$this->CI->session->set_userdata($data);
			
			$this->_generate(); // "remember me"
			
			$this->CI->load->view('auth/reg_success');
		}
	} // function register()
	
	
	/** 
	* Check to see if a user is logged in
	*
	* Look in the session and return the 'logged_in' part
	*
	* @access public
	* @param string
	*/
	function logged_in()
	{
		if($this->CI->session->userdata('logged_in') == TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	} // function logged_in()


	/** 
	* Check to see if a user is logging in with their username or their email
	*
	* @access private
	* @param string
	*/
	function _auth_type($str)
	{
		if(valid_email($str))
		{
			return 'email';
		}
		else
		{
			return 'username';
		}
	} // function _auth_type()
	
	
	/** 
	* Salt the users password
	*
	* @access private
	* @param string
	*/
	function _salt($str)
	{
		return sha1($this->CI->config->item('encryption_key').$str);
	} // function _salt()
	
	
	/** 
	* Verify that their username/email and password is correct
	*
	* @access private
	* @param string
	*/
	function _verify_details($auth_type, $username, $password)
	{
		$query = $this->CI->db->query("SELECT * FROM `users` WHERE `$auth_type` = '$username' AND `password` = '$password'");
		
		if($query->num_rows != 1)
		{
			$attempts = $_COOKIE['login_attempts'] + 1;
			setcookie("login_attempts", $attempts, time()+900, '/');
			return FALSE;
		}
		
		return TRUE;
	} // function _verify_details()
	
	
	/** 
	* Generate a new token/identifier from random.org
	*
	* @access private
	* @param string
	*/
	function _generate()
	{
		$username = $this->CI->session->userdata('username');
		
		$token_source = fopen("http://random.org/strings/?num=1&len=20&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new", "r");
		$token = fread($token_source, 20);
		
		$identifier = $username . $token;
		$identifier = $this->_salt($identifier);
		
		$this->CI->db->query("UPDATE `users` SET `identifier` = '$identifier', `token` = '$token' WHERE `username` = '$username'");
		
		setcookie("logged_in", $identifier, time()+3600, '/');
	}
	
	
	/** 
	* Verify that a user has a cookie, if not generate one. If the cookie doesn't match the database, log the user out and show them an error.
	*
	* @access private
	* @param string
	*/
	function _verify_cookie()
	{
		if((array_key_exists('login_attempts', $_COOKIE)) && ($_COOKIE['login_attempts'] >= 5))
		{
			$username = $this->CI->session->userdata('username');
			$userdata = $this->CI->db->query("SELECT * FROM `users` WHERE `username` = '$username'");
			
			$result = $userdata->result_array();

			$identifier = $result['0']['username'] . $result['0']['token'];
			$identifier = $this->_salt($identifier);
			
			if($identifier !== $_COOKIE['logged_in'])
			{
				session_destroy();
				
				show_error($this->CI->lang->line('logout_perms_error'));
			}
		}
		else
		{
			$this->_generate();
		}
	}
} // class Auth

?>