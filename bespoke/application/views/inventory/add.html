<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Add Inventory</title>
	<link rel="stylesheet" href="../../../resources/css/typography.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="../../../resources/css/forms.css" type="text/css" media="screen" title="no title" charset="utf-8">
	
	
	
	<script src="../../../resources/scripts/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
	
	
	
	
	<style type="text/css" media="screen">
		body {
			margin: 0 auto;
			width: 600px;
			font-family: Helvetica;
			font-size: 70%;
		}
		
		tbody tr.odd {background: #fff;}
		
	</style>
	
	
	
	
	
<script type="text/javascript" charset="utf-8">
	
	var materials = {

			0:{"id":0, "material":"Choose","unit":""},
			1:{"id":1, "material":"24 Kt Gold","unit":"Karat"},
			2:{"id":2, "material":"22 Kt Gold","unit":"Karat"},
			3:{"id":3, "material":"18 Kt Gold","unit":"Karat"},
			4:{"id":4, "material":"14 Kt Gold","unit":"Karat"},
			5:{"id":5, "material":"Diamonds - E/F VVSI", "unit":"Carat"},
			
			"length":6,

			select: function() {
				var current_material_id = $("#material option:selected").val();
				$("#unit").text(this[current_material_id]["unit"]);
				$("#amount").focus();
			},
			
			init: function() {
				var options = "";
				for(i=0;i < materials.length; i++)
				{
					options += "<option value="+ materials[i]["id"] + ">" + materials[i]["material"] + "</option>";
				}
				$("#material").html(options);

				$("#material").live("change",function() {
					materials.select();
				});
			}
	};
	
	var Detail = function(id) {
		
		this.id = id;
		
		this.add = function()
		{
			this.material = $("#material option:selected").val();
			this.unit = $("#unit").text();
			this.amount = $("#amount").val();
			this.cost_per_unit = $("#cost_per_unit").val();
			this.sp_per_unit = $("#sp_per_unit").val();

			this.add_to_table();
		}

		this.edit = function()
		{
			$("#material").val(this.material);
			$("#unit").text(this.unit);
			$("#amount").val(this.amount);
			$("#cost_per_unit").val(this.cost_per_unit);
			$("#sp_per_unit").val(this.sp_per_unit);

			$("#material").focus();
		}
		
		this.set = function(material, unit, amount, cost_per_unit, sp_per_unit)
		{
			this.material = material;
			this.unit = unit;
			this.amount = amount;
			this.cost_per_unit = cost_per_unit;
			this.sp_per_unit = sp_per_unit;
			
			this.add_to_table();
		}
		
		this.remove = function()
		{
			var cp = parseInt($("#cost_price").val()) - (this.cost_per_unit * this.amount);
			$("#cost_price").val(cp);
			var sp = parseInt($("#sale_price").val()) - (this.sp_per_unit * this.amount);
			$("#sale_price").val(sp);
			
			var element = "#detail_" + this.id;
			$(element).remove();
			this.id = null;
		}
		
	}
	
	
	Detail.prototype.add_to_table = function() {
		
		var cp = parseInt($("#cost_price").val()) + (this.cost_per_unit * this.amount);
		$("#cost_price").val(cp);
		var sp = parseInt($("#sale_price").val()) + (this.sp_per_unit * this.amount);
		$("#sale_price").val(sp);
		
		
		var tr = "<tr id='detail_" + this.id +"'>"

		tr += "<td>" + materials[this.material]["material"] + "</td>"
		tr += "<td>" + this.amount + "</td>"
		tr += "<td>" + this.unit + "</td>"
		tr += "<td>" + this.cost_per_unit + "</td>"
		tr += "<td>" + this.sp_per_unit + "</td>"
		tr += "<td><a href='#' onclick='product.remove_detail(" + this.id + ")'>x</a></td>"
		tr += "</tr>"

		$("#detail_list tbody").append(tr)

		$("#material").val(0);
		$("#unit").text("");
		$("#amount").val("");
		$("#cost_per_unit").val("");
		$("#sp_per_unit").val("");

		$("#material").focus();
	}
	
	
	var Product = function(id) {
		
		this.id = id;
		this.details = new Array();
		this.no_of_details = 0;
		
		this.add_detail = function() {
			this.details[this.no_of_details] = new Detail(this.no_of_details);
			this.details[this.no_of_details++].add();
		}
		
		// To be used when loading existing products
		this.set_detail = function(material, unit, amount, cost_per_unit, sp_per_unit) {
			this.details[this.no_of_details] = new Detail(this.no_of_details);
			this.details[this.no_of_details].set_details(material, unit, amount, cost_per_unit, sp_per_unit);
		}
		
		this.remove_detail = function(id)
		{
			this.details[id].remove();
			this.details[id] = null;
			this.no_of_details--;
		}
		
		this.save = function() {
			this.supplier_id = $("#supplier option:selected").val();
			this.supplier = $("#supplier option:selected").text();
			this.code = $("#product_code").val();
			this.title = $("#product_title").val();
			this.cost_price = $("#cost_price").val();
			this.sale_price = $("#sale_price").val();
			
			var post_data = {"id":this.id, "supplier":this.supplier_id, "code":this.code, "title":this.title, "details":this.details, "cost_price":this.cost_price, "sale_price":this.sale_price};
			/*
			$.post(	"url",
						 	post_data,
						 	function(data)
							{
								if(data.id <= 0)
									alert("Error saving product.");
								else
								{
									this.id = data.id;
								}
							},
							"json"
						);
			*/
						
			var tr = "<tr id='product_" + this.id +"'>"

			tr += "<td>" + this.code + "</td>"
			tr += "<td>" + this.title + "</td>"
			tr += "<td>" + this.supplier + "</td>"
			tr += "<td>" + this.sale_price + "</td>"
			tr += "</tr>"

			$("#product_list tbody").append(tr)
		}
	}
	
	
	$(document).ready(function() {		

		materials.init();
		product = new Product(0);

		$("#add_detail").click( function() {
			product.add_detail();
		});
		
		$("#add_product").click( function() {
			product.save();
		});
		
		// Alternate colors for rows
	  $('table tbody tr:odd').addClass('odd');
	  $('table tbody tr:even').addClass('even');

		// After an update we run this again
	  var alternateRowColors = function($table) {
	    $('tbody tr:odd', $table).removeClass('even').addClass('odd');
	    $('tbody tr:even', $table).removeClass('odd').addClass('even');
	  };
	

	});

</script>


</head>

<body id="add_inventory">
	<h2>bespoke</h2>
	
	<form action="" method="post" accept-charset="utf-8">
		
		<h3>add inventory
		<br/>
		<input type="text" name="product_title" value="" id="product_title" class="title" size="34">
		</h3>
		
		<table border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td>
					<label for="supplier">Supplier</label>
					<select name="supplier" id="supplier" size="1">
						<option value="0">Self</option>
						<option value="1">V2 International</option>
					</select>
				</td>
				<td>
					<label for="product_code">Product Code</label>
					<input type="text" name="product_code" value="" id="product_code" size="10">
				</td>
				<td>
					<label for="cost_price">Cost Price</label>
					<input type="text" name="cost_price" value="0" id="cost_price" size="10">
				</td>
				<td>
					<label for="sale_price">Sale Price</label>
					<input type="text" name="sale_price" value="0" id="sale_price" size="10">
				</td>
			</tr>
		</table>


		<table border="0" cellspacing="1" cellpadding="5" id="detail_list">
			<thead>
			<tr>
				<th colspan="6">Details</th>
			</tr>
			<tr>
				<th>Material</th>
				<th>Amount</th>
				<th>Unit</th>
				<th>Cost per Unit</th>
				<th>S.P. per Unit</th>
				<th></th>
			</tr>
			</thead>
			<tbody>

			</tbody>
			<tfoot>
			<tr>
				<td>
					<select name="material" id="material" size="1">
					</select>
				</td>
				<td>
					<input type="text" name="amount" value="" id="amount" size="10">
				</td>
				<td>
					<span id="unit"></span>
				</td>
				<td>
					<input type="text" name="cost_per_unit" value="" id="cost_per_unit" size="10">
				</td>
				<td>
					<input type="text" name="sp_per_unit" value="" id="sp_per_unit" size="10">
				</td>
				<td>
					<input type="button" name="add_detail" value=" + " id="add_detail">
			</tr>
			</tfoot>
		</table>	
		<table border="0" cellspacing="1" cellpadding="0">
			<tr>

			</tr>
		</table>
		<p>
			<input type="button" name="add_product" value=" Add Product " id="add_product">
		</p>
	</form>
	
	<div>
		<table border="0" cellspacing="1" cellpadding="5" id="product_list">
			<thead>
			<tr>
				<th>Product Code</th>
				<th>Product</th>
				<th>Details</th>
				<th>Sale Price</th>
			</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
</body>