<?php

class Dashboard extends Application {
	
	function Dashboard() {
		parent::Application();
	}
	
	function index() {
		
		if(! $this->auth->logged_in()) {
			$this->auth->login();
			return;
		}

		$data['accounts'] = $this->db->get('accounts')->result();
		$data['balances'] = $this->get_balances();
		$this->load->view('dashboard_view', $data);

	}
	
	function show($account_id = 0)
	{
		if(! $this->auth->logged_in()) {
			$this->auth->login();
			return;
		}
		
		$account = new Account();
		$account->get_by_id($account_id);
		
		$transactions = new Transaction();
		$transactions->order_by('date desc');
		$transactions->where_related_account('id', $account->id)->get();
		
		$data['account_name'] = $account->name;
		
		$this->load->library('table');
		
		$this->table->set_heading('ID', 'Date', 'Description', 'Debit', 'Credit');
		
		foreach($transactions->all as $transaction)
			$this->table->add_row(array($transaction->id, $transaction->date, $transaction->description, $transaction->debit, $transaction->credit));
		
		$data['table'] = $this->table->generate();
		$this->load->view('show_view', $data);
	}
	
	function transfer() {
		
		if(! $this->auth->logged_in()) {
			$this->auth->login();
			return;
		}
		
		$from_account = new Account();
		$from_account->get_by_id($this->input->post('from_account_id'));
		
		$to_account = new Account();
		$to_account->get_by_id($this->input->post('to_account_id'));
		
		
		// First debit the amount
		$transaction = new Transaction();
		
		$transaction->date = $this->input->post('transfer_date');
		$transaction->description = "Transfer from $from_account->name to $to_account->name";
		
		$transaction->debit = $this->input->post('amount');
		$transaction->credit = NULL;
		
		$transaction->save($from_account);
		
		// Now credit the amount
		$transaction = new Transaction();
		
		$transaction->date = $this->input->post('date');
		$transaction->description = "Transfer from $from_account->name to $to_account->name";
		
		$transaction->credit = $this->input->post('amount');
		$transaction->debit = NULL;
		
		$transaction->save($to_account);
		
		$this->index();
		
	}
	
	function new_transaction()
	{
		if(! $this->auth->logged_in()) {
			$this->auth->login();
			return;
		}
		
		$account = new Account();
		$transaction = new Transaction();
		
		$account->get_by_id($this->input->post('account_id'));
		
		$transaction->date = $this->input->post('date');
		$transaction->description = $this->input->post('description');
		$transaction->credit = $this->input->post('credit');
		$transaction->debit = $this->input->post('debit');
		
		$transaction->save($account);
		
		$this->index();
	}

	function get_balances() 
	{
		if(! $this->auth->logged_in()) {
			$this->auth->login();
			return;
		}
		
		$balances = array();
		
		$accounts = new Account();
	
		$accounts->get();
		
		foreach ($accounts->all as $account)
		{
			$balances[$account->id]['id'] = $account->id;
			$balances[$account->id]['name'] = $account->name;
			$balances[$account->id]['number'] = $account->number;
			
			$transaction = new Transaction();
			$transaction->select_sum('credit', 'total_credit');
			$transaction->select_sum('debit', 'total_debit');
			$transaction->where_related_account('id', $account->id)->get();
	
			$balances[$account->id]['balance'] = $transaction->total_credit - $transaction->total_debit;
		}
		
		return $balances;
	}
	
	function logout() {
		$this->auth->logout();
	}
}


?>