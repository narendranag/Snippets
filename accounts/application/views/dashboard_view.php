<?$this->load->view('template/header');?>
<h4>Current Status</h4>
<div id="balances" style="padding: 10px 10px 10px 10px">
	<?
	foreach ($balances as $balance)
	{
		$id = $balance['id'];
		$link = $balance['name'] . " : Rs. " . $balance['balance'];
		echo "<h3>" . anchor("dashboard/show/$id", $link)  . "</h3>";
	}
	?>
</div>
<h4>Transfer Money</h4>
<div id="transfer" style="padding: 10px 10px 10px 10px">
	<?=form_open('dashboard/transfer');?>
	<li><label for="date">Transfer Date</label><br/><input type="text" name="transfer_date" value="<?=date("m/d/Y");?>" id="transfer_date" class="datepicker" size="10"/></li>
	<li><label for="from_account_id">From</label><br/><select name="from_account_id" id="from_account_id" size="1">
		<?
		foreach($accounts as $account)
			echo "<option value=$account->id>$account->name</option>";
		?>
	</select></li>
	<li><label for="to_account_id">To</label><br/><select name="to_account_id" id="to_account_id" size="1">
		<?
		foreach($accounts as $account)
			echo "<option value=$account->id>$account->name</option>";
		?>
	</select></li>
	<li><label for="amount">Amount</label><br/><input type="text" name="amount" value="" id="amount" size="10"></li>
	<li><br/><input type="submit" name="some_name" value=" Transfer " id="some_name"></li>
	<?=form_close();?>
</div>

<h4>New Transaction</h4>
<div id="new_transaction" style="padding: 10px 10px 10px 10px">
	
	<?=form_open('dashboard/new_transaction');?>
	<li><label for="account_id">Choose Account</label><br/><select name="account_id" id="account_id" size="1">
		<?
		foreach($accounts as $account)
			echo "<option value=$account->id>$account->name</option>";
		?>
	</select></li>
	<li><label for="date">Transaction Date</label><br/><input type="text" name="date" value="" id="date" class="datepicker" size="10"/></li>
	<li><label for="description">Description</label><br/><input type="text" name="description" value="" id="description" size="50"></li>
	<li><label for="debit">Withdrawal</label><br/><input type="text" name="debit" value="" id="debit" size="10"></li>
	<li><label for="credit">Deposit</label><br/><input type="text" name="credit" value="" id="credit" size="10"></li>
	<li><br/><input type="submit" name="some_name" value=" Commit " id="some_name"></li>
	<?=form_close();?>
</div>
<?$this->load->view('template/footer');?>