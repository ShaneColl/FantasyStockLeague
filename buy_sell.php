<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="UTF-8">
		<title>Fantasy Stock League</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
		<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
		<link rel="stylesheet" href="css/style.css">
			<style>
			.alignleft {
				float: left;
			}
			.alignright {
				float: right;
			}
			</style>
		<script
		 src="https://code.jquery.com/jquery-3.3.1.js"
		 integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
		 crossorigin="anonymous">
		 </script>
		<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
		<script type="text/javascript" src="DataTables/datatables.min.js"></script>
	</head>
	<body>
		<link href= "https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
		<h1 id = "player_name" class = "text-center" style="font-size:40px;"><strong>Player: </strong></h1>
		<h1 id = "game_name" class = "text-center" style="font-size:40px;"><strong>Game Name: </strong></h1>
		<h1 id = "gm_name" class = "text-center" style="font-size:40px;"><strong>GM_Name: </strong></h1>
		<div class = "container-fluid">
			<div class = "well outter-well" id="num1">
				<h1 class = "text-center" style="font-size:40px;"><strong>Buy/Sell Table</strong></h1>
			<form id="searchForm" action="search" method="post">
				 <div id="info">
					<div class="alignleft">Search Company: </div>
					<div class="alignright">Total Money:</div>
				 </div>
				 <br></br>
				<input type="text" placeholder="Company Ticker" class="get_searchsearch" onkeydown="get_search(this)" />
			</form>
				<div class = "well well-sm" id="num2">
					<table id="main_table" class="display">
						<thead>
							<tr>
								<th></th>
								<th>Company</th>
								<th>Value</th>
								<th>Total Value</th>
								<th>Total Amount</th>
								<th>Increments</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<button type="button" class="btn-md button-new transaction"> Buy/Sell Stock </button>
			</div>
			<div class = "row">
				<div class = "col-md-2 col-md-2">
					<a class="btn-md button-new ubuntu-font" href="userHub.html">Back to Game Hub</a>
				</div>
			</div>
		</div>
		<?php 
		
		session_start(); 
		
		$session_name = $_SESSION['session_name'];
		$email = $_SESSION['email'];
		$GM_Email = $_SESSION['GM_email'];
		
		?>

		<script>
		function test(q) {
			console.log("entering test");
			$.getJSON("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=" + q +"&interval=1min&apikey=57FPBKMUD9NS4AAH", function(json) {
				console.log("fetched api");
				console.log(json);
				if(json.hasOwnProperty('Meta Data')) {
				var metaData = json["Meta Data"];
				var metaDataObject = Object.keys(metaData);
				var symbol = metaData[metaDataObject[1]];
			//	console.log("Symbol: " + symbol);

								var priceTimeSeries = json["Time Series (1min)"];
								var priceTimeSeriesObject = Object.keys(priceTimeSeries);
								//Sets price equal to the most recent closing price.
								var price = parseFloat(priceTimeSeries[priceTimeSeriesObject[0]]["4. close"]);
								var obj = {company: symbol, price: price, number: 0};

								PopulateTable(obj);
				}

				else{
					console.log("problem here does not have meta data");
				}
		});
		}

		var table_rows = [];
		$(document).ready( function () {
			$('#main_table').DataTable();

			<?php
			 $mysqli = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
			 if (mysqli_connect_errno())
			   {
			   echo "Failed to connect to MySQL: " . mysqli_connect_error();
			   }
			 $querystring = "SELECT * FROM session_data WHERE owner = '" . $email . "' and email_GM = '" . $GM_Email . "' and session_name = '" . $session_name . "'";
			 $result = $mysqli->query($querystring);
			 if (!$result) {
			 	echo 'Could not run query: ' . mysqli_error();
			 }
			 while( $row = mysqli_fetch_assoc($result)) {
			 	?>
			 	var Tstockticker = "<?php echo $row['stock_ticker'] ?>";
			 	var Tprice = "<?php echo $row['price'] ?>";
			 	var Tnumber = "<?php echo $row['number'] ?>";
			 	var entry = {company: Tstockticker, price: Tprice, number: Tnumber};
			 	table_rows.push(entry);
			 	<?php
			 }
			 $querystring = "SELECT * FROM session_player_data WHERE email_INV = '" . $email . "' and email_GM = '" . $GM_Email . "' and session_name = '" . $session_name . "'";
			 $result = $mysqli->query($querystring);
			 if (!$result) {
			 	echo 'Could not run query: ' . mysqli_error();
			 }
			 ?>
			 var player_cash = -1;
			 <?php
			 while( $row = mysqli_fetch_assoc($result)) {
				?>
			 	player_cash = "<?php echo $row['total_score'] ?>";
			 	<?php
			 }
			 mysqli_close($mysqli);
			 ?>
			 $('#player_name').text("Player: "+"<?php echo $email;?>");
			 $('#game_name').text("Game Name: "+"<?php echo $session_name;?>");
			 $('#gm_name').text("Gm Name: "+"<?php echo $GM_Email;?>");
			 $('#info').children(".alignright").text("Total Money: "+player_cash);
			 
			 var arrayLength = table_rows.length;
			 var companyList = [];
			 for (var i = 0; i < arrayLength; i++) {
			 	var outsideObj = (table_rows[i]);
			 	var outsideCompany = outsideObj.company;
				var repeat = false;
				for (var x = 0; x < companyList.length; x++){
					if (companyList[x] == outsideCompany){
					repeat = true;
					}
				}
				if (repeat == false){
					var total_number = parseInt(outsideObj.number);
					for (var j = 0; j < arrayLength; j++){
						var insideObj = (table_rows[j]);
						var insideCompany = insideObj.company;
						if (j != i && outsideCompany == insideCompany){ //don't want to count same company stock purchase/sell twice
							total_number += parseInt(insideObj.number);
						}
					}
					if (total_number > 0){
						var finalObj = {company: outsideCompany, price: outsideObj.price, number: total_number};
						PopulateTable(finalObj);
						companyList.push(outsideCompany);
					}
				}
			 }
		} );

		//PUT LOGIC FOR API IN THIS FUNCTION. THIS IS FOR CREATING NEW ROWS. Need current price from API.
		function PopulateTable(obj){
				var rowData = [];
				var table = $('#main_table').DataTable();
				var db_data1 = obj.company; //stock ticker name
				var db_data2 = "$"+Number.parseFloat(obj.price).toFixed(2); //current individual stock value
				var db_data3 = (parseInt(obj.number) * parseFloat(obj.price)); //total value
				db_data3 = "$"+Number.parseFloat(db_data3).toFixed(2);
				var db_data4 = obj.number; //this is the amount of stock currently owned by player. set to 0 if no stock owned
				rowData.push('<button type="button" class="dt-delete"> Delete</button>');
				rowData.push('<p id="stock_ticker">'+ db_data1 +'</p>');
				rowData.push('<p id="value">'+ db_data2 +'</p>');
				rowData.push('<p id="total_value">'+ db_data3 +'</p>');
				rowData.push('<p id="total_amount">'+ db_data4 +'</p>');
				rowData.push(   ' <input id="amount" type="text" value="0" size="10"/>'+
								'<button id="up" class="up_button" size="2" >+</button>'+
								'<button id="down" class="down_button" size="2">-</button>');
				table.row.add(rowData).draw( false );
		}

		function tableContainsElement(element) {

			var table = $('#main_table').DataTable();
			var data = table.data().toArray();
			var tableRows = Object.keys(data).length;
			for( i = 0; i < tableRows; i++) {
				console.log("Element: " + element + "data: " + $(data[i][1]).text());
				if(element === $(data[i][1]).text())
					return true;
			}

			return false;

		}


		function get_search(ele) {
			if(event.key === 'Enter') {

				if(!tableContainsElement(ele.value)) {
				console.log("table does not contain: " + ele.value);
				test(ele.value);
				}
				else{
					console.log("Table already contains: " + ele.value)
				}
				ele.value = "";
			}
		}

		$("#searchForm").submit(function() {
			return false;
		});

		$('#main_table').on('click', ".dt-delete", function(evt){
			var table = $('#main_table').DataTable();
			table.row($(this).parents('tr')).remove().draw( false );
		});

		$('#main_table').on('click', ".up_button", function(evt){
			$(this).parents('tr').children().children('#amount').val(parseInt($(this).parents('tr').children().children('#amount').val())+1);
			var amount = $(this).parents('tr').children().children('#amount').val();
			var total_amount = $(this).parents('tr').children().children('#total_amount').text();
			var price = $(this).parents('tr').children().children('#value').text().substring(1,$(this).parents('tr').children().children('#value').text().length);
			var val = (parseInt(amount)+parseInt(total_amount))*parseFloat(price);
			val = (val).toFixed(2);
			$(this).parents('tr').children().children('#total_value').text("$"+val);
		});

		$('#main_table').on('click', ".down_button", function(evt){
			var amount = $(this).parents('tr').children().children('#amount').val();
			var total_amount = $(this).parents('tr').children().children('#total_amount').text();
			if ((parseInt(total_amount) + parseInt(amount)-1) >= 0){
				$(this).parents('tr').children().children('#amount').val(parseInt($(this).parents('tr').children().children('#amount').val())-1);
				amount = $(this).parents('tr').children().children('#amount').val();
				total_amount = $(this).parents('tr').children().children('#total_amount').text();
				var price = $(this).parents('tr').children().children('#value').text().substring(1,$(this).parents('tr').children().children('#value').text().length);
				var val = (parseInt(amount)+parseInt(total_amount))*parseFloat(price);
				val = (val).toFixed(2);
				$(this).parents('tr').children().children('#total_value').text("$"+val);
			}
		});

		$('#num1').on('click', ".transaction", function(evt){
			var table = $('#main_table');
			var row = table.children('tbody');
			row.children().each(function () {
				var ticker = $(this).children().children('#stock_ticker').text();
				var value = $(this).children().children('#value').text().substring(1,$(this).children().children('#value').text().length);
				var total_value = $(this).children().children('#total_value').text();
				var amount = $(this).children().children('#amount').val();
				var total_amount = $(this).children().children('#total_amount').text();
				if ((parseInt(amount) > 0 || parseInt(amount) < 0) && (parseInt(total_amount)+parseInt(amount)) >= 0){
					$.ajax({
					  type: 'POST',
					  url: 'buy_sell_dbInsert.php',
					  data: {'ticker': ticker, 'value': value, 'total_value': total_value, 'amount': amount},
					});
					if ((parseInt(total_amount)+parseInt(amount)) == 0){
						var tablex = $('#main_table').DataTable();
						tablex.row($(this)).remove().draw( false );
					}
					else{
						total_amount = parseInt(total_amount)+parseInt(amount);
						$(this).children().children('#total_amount').text(total_amount);
						var val = (parseInt(total_amount)*parseFloat(value)).toFixed(2);
						$(this).children().children('#total_value').text("$"+val);
						$(this).children().children('#amount').val(0);
					}
				}
				else{
					if (parseInt(total_amount) == 0){
						var tablex = $('#main_table').DataTable();
						tablex.row($(this)).remove().draw( false );
					}
				}
			});
		});

		</script>


		<script>


			function updateTable(row, price, symbol) {
				var table = $('#main_table').DataTable();
				var data = table.data().toArray();

				price = (price).toFixed(2);

				var currentPrice = "$" + price;
				table.cell(row, 2).data('<p id="value">'+ currentPrice +'</p>');

				var tabl = $('#main_table')
				var tRow = tabl.children('tbody');


				tRow.children().each(function () {
					console.log("here");
					var symbol2 = $(this).children().children('#stock_ticker').text();
					if(symbol === symbol2) {
						//console.log("symbols same");
						console.log("symbol: " + symbol +"price: " + price);
						var amount = parseInt($(this).children().children('#amount').val());
						var total_amount = parseInt($(this).children().children('#total_amount').text());
                                                console.log("total amount: " + total_amount);
					        var val = (amount + total_amount) * parseFloat(price);
						val = (val).toFixed(2);
						val = "$" + val;
						$(this).children().children('#total_value').text(val);
					}

				});

			}


			function callApi(data, row) {
				$.getJSON("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol="+ $(data[i][1]).text() +"&interval=1min&apikey=57FPBKMUD9NS4AAH", function(json) {

					//Making sure the correct Json file is received
					if(json.hasOwnProperty('Meta Data')) {
						var metaData = json["Meta Data"];
						var metaDataObject = Object.keys(metaData);
						var symbol = metaData[metaDataObject[1]];
						var priceTimeSeries = json["Time Series (1min)"];
						var priceTimeSeriesObject = Object.keys(priceTimeSeries);
						//Sets price equal to the most recent closing price.
						var price = parseFloat(priceTimeSeries[priceTimeSeriesObject[0]]["4. close"]);

						updateTable(row, price, symbol)
					}
					  });

			}

		    setInterval(function() {
					console.log("running?");
					var table = $('#main_table').DataTable();
					var data = table.data().toArray();
					var tableRows = Object.keys(data).length;
					for( i = 0; i < tableRows; i++) {
		       callApi(data, i);
		      }

		    }, 30000);//Every 60 seconds

		    </script>






</body>

