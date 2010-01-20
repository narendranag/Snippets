<ul id="menu">
	<li>Hello <?=$this->session->userdata['username'];?>
	<li><?=anchor('dashboard', 'dashboard');?></li>
	<li><?=anchor('dashboard/logout', 'logout');?></li>
</ul>