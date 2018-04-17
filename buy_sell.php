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
				margin: 2px
			}
			.alignrightbox {
				width: 100px;
				float: right;
				margin: 5px
				border: 20px solid green;
			}
			.bg-danger{
				display: none;
			}
			</style>
		<script
		 src="https://code.jquery.com/jquery-3.3.1.js"
		 integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
		 crossorigin="anonymous">
		 </script>
		<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
		<script type="text/javascript" src="DataTables/datatables.min.js"></script>
		<script type="text/javascript" src="js/jquery.blockUI.js"></script>
	</head>
	<body>
		<link href= "https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
		<div class = "container-fluid">
			<div class = "well outter-well" id="num1">
				<h1 id = "player_name" class = "text-left" style="font-size:20px;"><strong>Player: </strong></h1>
				<h1 id = "game_name" class = "text-left" style="font-size:20px;"><strong>Game Name: </strong></h1>
				<h1 id = "gm_name" class = "text-left" style="font-size:20px;"><strong>Game Creator: </strong></h1>
				<div class = "row">
					<a class="btn button-new ubuntu-font col-xs-2" href="userHub.php">Back to Game Hub</a>
					<h1 class = "text-center col-xs-8" style="font-size:40px;"><strong>Buy/Sell Table</strong></h1>
				</div>
			<form id="searchForm" action="search" method="post">
				 <div id="info">
					<div class="alignleft">Search Company: </div>
					<div id="portfolio" class="alignrightbox">Total Portfolio Amount: $0.00</div>
					<div id="liquidity" class="alignrightbox">Total Liquidity Amount: $0.00</div>
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
				<div class = "row" id="transaction">
					<div id="total_transaction" class="alignright">Total Transaction Amount: $0</div>
				</div>
				<div class = "row">
					<button type="button" class="btn btn-lg button-new ubuntu-font col-xs-12 col-sm-3 col-sm-offset-9 transaction"> Buy/Sell Stock </button>
				</div>
                                <br></br>
				<p id="error_box" class="bg-danger" style="font-size:20px;">ERROR MESSAGE TEST 123</p>
			</div>
		</div>
		<?php

		session_start();

		$session_name = $_SESSION['session_name'];
		$email = $_SESSION['email'];
		$GM_Email = $_SESSION['GM_email'];

		?>

		<script>
		

		//global variables
		var table_rows = [];
		var end_date = null;
		var allow_DT = null;
		var stock_limit = null;
		global_pause = false;
		
		$(document).ready( function () {
			document.getElementById("error_box").style.color = "red";
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
			 	var Tstockticker = "<?php echo $row['stock_ticker']; ?>";
			 	var Tprice = "<?php echo $row['price']; ?>";
			 	var Tnumber = "<?php echo $row['number']; ?>";
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
			 	player_cash = "<?php echo $row['total_score']; ?>";
			 	<?php
			 }
			 
			 $querystring = "SELECT * FROM session_list WHERE email_GM = '" . $GM_Email . "' and session_name = '" . $session_name . "'";
			 $result = $mysqli->query($querystring);
			 if (!$result) {
			 	echo 'Could not run query: ' . mysqli_error();
			 }
			 while( $row = mysqli_fetch_assoc($result)) {
			 	?>
				end_date = "<?php echo $row['end_date']; ?>";
			 	allow_DT = "<?php echo $row['allow_DT']; ?>";
			 	stock_limit = "<?php echo $row['stock_limit']; ?>";
			 	<?php
			 }

			 ?>
			 $('#player_name').text("Player: "+"<?php echo $email;?>");
			 $('#game_name').text("Game Name: "+"<?php echo $session_name;?>");
			 $('#gm_name').text("Game Creator: "+"<?php echo $GM_Email;?>");
			 $('#info').children("#liquidity").text("Total Liquidity Amount: $"+player_cash);
			 var date_object = new Date(end_date);
			 var cur_date_object = new Date('<?php echo date("Y-m-d"); ?>');
			 if (end_date != null && date_object > cur_date_object){ 
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
						if (total_number > 0){ //if buy/sell transactions come out positive, means this is currently owned by player
							var finalObj = {company: outsideCompany, price: outsideObj.price, number: total_number};
							PopulateTable(finalObj);
							companyList.push(outsideCompany);
						}
					}
				 }
				var table = $('#main_table').DataTable();
				var data = table.data().toArray();
				var tableRows = Object.keys(data).length;
				for( i = 0; i < tableRows; i++) {
					callApi(data, i);
				}
			 }
			 else{
				$.blockUI({ message: "The game's end date has passed. This game has finished." }); 
			 }
		} );

		function PopulateTable(obj){
				var rowData = [];
				var table = $('#main_table').DataTable();
				var db_data1 = obj.company; //stock ticker name
				var db_data2 = "$"+Number.parseFloat(obj.price).toFixed(2); //current individual stock value
				var db_data3 = (parseInt(obj.number) * parseFloat(obj.price)); //total value
				db_data31 = "$"+Number.parseFloat(db_data3).toFixed(2);
				var db_data4 = obj.number; //this is the amount of stock currently owned by player. set to 0 if no stock owned

				var cur_portfolio = parseFloat($('#info').children("#portfolio").text().substring(25,$('#info').children("#portfolio").text().length));
				cur_portfolio += db_data3; //add total stock value to portfolio value
				$('#info').children("#portfolio").text("Total Portfolio Amount: $"+cur_portfolio.toFixed(2));

				rowData.push('<button type="button" class="dt-delete"> Delete</button>');
				rowData.push('<p id="stock_ticker">'+ db_data1 +'</p>');
				rowData.push('<p id="value">'+ db_data2 +'</p>');
				rowData.push('<p id="total_value">'+ db_data31 +'</p>');
				rowData.push('<p id="total_amount">'+ db_data4 +'</p>');
				rowData.push(   ' <input id="amount" type="text" value="0" size="10"/>'+
								'<button id="up" class="up_button" size="2" >+</button>'+
								'<button id="down" class="down_button" size="2">-</button>');
				table.row.add(rowData).draw( false );
		}
		
		function test(q) {
			$.blockUI({
			css: { 
				border: 'none', 
				padding: '15px', 
				backgroundColor: '#4682B4', 
				opacity: 1, 
				color: '#FFFFFF',
				fontSize:'20px'
			},
			overlayCSS: { 
				backgroundColor: '#000000', 
				opacity: 0.6, 
			},
			message: "Waiting to load stock from database..." 
			});
			
			//two race condition variables.
			var time_elapsed = false;
			var finished_correctly = false;
			setTimeout(function(){
					time_elapsed = true;
					if (!finished_correctly){
					global_pause = false;
					$.unblockUI();
						$('#error_box').text("Error: took too long to return with stock. Please try again.");
						$('#error_box').show();
					}
			}, 10000);
			$.getJSON("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=" + q +"&interval=1min&apikey=57FPBKMUD9NS4AAH", function(json) {
				console.log("fetched api");
				console.log(json);
				//only look at stock info after api loads IF the timeout hasnt occurred. 
				if (!time_elapsed){
					finished_correctly = true;
					global_pause = false;
					$('#error_box').hide();
					$.unblockUI();
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
						$('#error_box').text("Error: stock not found for given company");
						$('#error_box').show();
					}
				}
			});
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
			if(event.key === 'Enter' && global_pause == false) {
				global_pause = true;
				var temp_v = ele.value.toUpperCase();
				if(!tableContainsElement(temp_v)) {
					$('#error_box').hide();
					test(ele.value.toUpperCase());
				}
				else{
					global_pause = false;
					$('#error_box').text("Error: Transaction violates day-trading rules. Stock(s) causing violations: "+ticker_string.substring(0,ticker_string.length-1));
					$('#error_box').show();
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
			if (!global_pause){
				$(this).parents('tr').children().children('#amount').val(parseInt($(this).parents('tr').children().children('#amount').val())+1);
				var amount = $(this).parents('tr').children().children('#amount').val();
				var total_amount = $(this).parents('tr').children().children('#total_amount').text();
				var price = $(this).parents('tr').children().children('#value').text().substring(1,$(this).parents('tr').children().children('#value').text().length);
				var val = (parseInt(amount)+parseInt(total_amount))*parseFloat(price);
				val = (val).toFixed(2);
				var total_transaction = parseFloat($("#total_transaction").text().substring(27,$("#total_transaction").text().length));
				total_transaction += parseFloat(price); //add current price to transaction
				$("#total_transaction").text("Total Transaction Amount: $"+total_transaction.toFixed(2));
				$(this).parents('tr').children().children('#total_value').text("$"+val);
			}
		});

		$('#main_table').on('click', ".down_button", function(evt){
			if (!global_pause){
				var amount = $(this).parents('tr').children().children('#amount').val();
				var total_amount = $(this).parents('tr').children().children('#total_amount').text();
				if ((parseInt(total_amount) + parseInt(amount)-1) >= 0){
					$(this).parents('tr').children().children('#amount').val(parseInt($(this).parents('tr').children().children('#amount').val())-1);
					amount = $(this).parents('tr').children().children('#amount').val();
					total_amount = $(this).parents('tr').children().children('#total_amount').text();
					var price = $(this).parents('tr').children().children('#value').text().substring(1,$(this).parents('tr').children().children('#value').text().length);
					var val = (parseInt(amount)+parseInt(total_amount))*parseFloat(price);
					val = (val).toFixed(2);
					var total_transaction = parseFloat($("#total_transaction").text().substring(27,$("#total_transaction").text().length));
					total_transaction -= parseFloat(price); //add current price to transaction
					$("#total_transaction").text("Total Transaction Amount: $"+total_transaction.toFixed(2));
					$(this).parents('tr').children().children('#total_value').text("$"+val);
				}
			}
		});

		$('#num1').on('click', ".transaction", function(evt){
			if (!global_pause){
				var table = $('#main_table');
				var cur_liquidity = parseFloat($('#info').children("#liquidity").text().substring(25,$('#info').children("#liquidity").text().length));
				var cur_portfolio = parseFloat($('#info').children("#portfolio").text().substring(25,$('#info').children("#portfolio").text().length));
				var total_transaction = parseFloat($("#total_transaction").text().substring(27,$("#total_transaction").text().length));
				var row = table.children('tbody');
				var cur_unique_stocks = 0;
				row.children().each(function () {
				cur_unique_stocks++;
				});
				var ticker_string = "";
				if (cur_liquidity >= total_transaction && cur_unique_stocks <= stock_limit){
					$('#error_box').hide();
					//got to check for Day trading (DT).
					//Go through each entry in transaction table BEFORE allowing it to continue to DB submition
					
					var dt_found = false;
					$.blockUI({ message: "Waiting for transaction to process..." });
					row.children().each(function () {
						var no_prior = 0;
						var amount = parseInt($(this).children().children('#amount').val());
						var ticker = $(this).children().children('#stock_ticker').text();
						var dt_date = "<?php echo date("Y-m-d") ?>";
						console.log("Date is: "+dt_date);
						console.log("Ticker is: "+ticker);
						//if actual transaction and not just a empty stock sitting in table
						if (amount > 0 || amount < 0){
							//async ajax.... will freeze page, so the freezeUI function occurs before this point
							$.ajax({
							url: 'buy_sell_dtCheck.php',
							type: 'POST',
							async: false,
							cache: false,
							timeout: 10000,
							data: {'ticker': ticker, 'date': dt_date},
								error: function(){
									console.log("ERROR one ajax...: "+val);
									//let it slide if error occurs
								},
								success: function(val){
									console.log("Finished one ajax!: "+val);
									if (parseInt(val) == 1){
									console.log("Finished one ajax successfully!!!: "+val);
									dt_found = true; //1 means it found a transaction with same date in DB
									ticker_string += ticker+",";
									}
									return val;
								}
							});
						}
					});
					$.unblockUI();
					
					
					//if ((allow_DT == "F" && dt_found == false) || (allow_DT == "T")){
					if ((allow_DT == "F" && dt_found == false) || (allow_DT == "T")){	
						row.children().each(function () {
							var ticker = $(this).children().children('#stock_ticker').text();
							var value = $(this).children().children('#value').text().substring(1,$(this).children().children('#value').text().length);
							var total_value = $(this).children().children('#total_value').text();
							var amount = $(this).children().children('#amount').val();
							var total_amount = $(this).children().children('#total_amount').text();
							if ((parseInt(amount) > 0 || parseInt(amount) < 0) && (parseInt(total_amount)+parseInt(amount)) >= 0){
								global_pause = true;
								$('#error_box').text("Transaction successful!")
								document.getElementById("error_box").style.color = "green";
								$('#error_box').show();
								setTimeout(function(){
										document.getElementById("error_box").style.color = "red";
										$('#error_box').hide();
										global_pause = false;
								}, 2000);
								cur_liquidity -= (parseInt(amount)*parseFloat(value)); //add to liquidity if (stock # * value) is sell transaction, otherwise subtract b/c its a buy transaction
								cur_portfolio += (parseInt(amount)*parseFloat(value)); //buying adds to portfolio instead of subtracting from it, so opposite operation of liquidity code line above
								$.ajax({
								  type: 'POST',
								  url: 'buy_sell_dbInsert.php',
								  data: {'ticker': ticker, 'value': value, 'total_value': total_value, 'amount': amount, 'player_money': cur_liquidity, 'date': "<?php echo (date("Y-m-d")." ".date("h:i:s")); ?>"},
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
								$("#total_transaction").text("Total Transaction Amount: $0");
							}
							else{
								if (parseInt(total_amount) == 0){
									var tablex = $('#main_table').DataTable();
									tablex.row($(this)).remove().draw( false );
								}
							}
						});
				$('#info').children("#liquidity").text("Total Liquidity Amount: $"+cur_liquidity.toFixed(2));//update liquidity table after transactions finished
				$('#info').children("#portfolio").text("Total Portfolio Amount: $"+cur_portfolio.toFixed(2));//update portfolio table after transactions finished
				}
				else{
					$('#error_box').text("Error: Transaction violates day-trading rules. Stock(s) causing violations: "+ticker_string.substring(0,ticker_string.length-1));
					$('#error_box').show();
				}
			}
			else{
				if (cur_liquidity < total_transaction){
					$('#error_box').text("Error: Not enough money to complete purchase.")
				}
				else if (cur_unique_stocks > stock_limit){
					$('#error_box').text("Error: Too many unique stocks. Unique stock limit is: "+stock_limit);
				}
				else{
					$('#error_box').text("Error: Unspecified")
				}
				$('#error_box').show();
			//timeout not really needed, as the error disappears at next valid transaction
			//setTimeout(function(){ $('#error_box').hide(); }, 10000);
			}
		}
	});


			function updateTable(row, price, symbol) {
				var table = $('#main_table').DataTable();
				var data = table.data().toArray();
				var tabl = $('#main_table');
				var tRow = tabl.children('tbody');
				

				tRow.children().each(function () {
					console.log("here");
					var symbol2 = $(this).children().children('#stock_ticker').text();
					if(symbol === symbol2) {
						global_pause = true;
						//console.log("symbols same");

						//grab old price value
						var old_price = $(this).children().children('#value').text().substring(1,$(this).children().children('#value').text().length);
						price = (price).toFixed(2);
						var currentPrice = "$" + price;
						//update new price, now that old has been grabbed
						table.cell(row, 2).data('<p id="value">'+ currentPrice +'</p>');

						console.log("symbol: " + symbol +"price: " + price);
						var amount = parseInt($(this).children().children('#amount').val());
						var total_amount = parseInt($(this).children().children('#total_amount').text());
                        console.log("total amount: " + total_amount);
					    var val = (amount + total_amount) * parseFloat(price);
						val = (val).toFixed(2);

						var total_transaction = parseFloat($("#total_transaction").text().substring(27,$("#total_transaction").text().length));
						total_transaction -= (old_price * amount); //remove old price from transaction
						total_transaction += (parseFloat(price) * amount); //add new price to transaction
						$("#total_transaction").text("Total Transaction Amount: $"+total_transaction.toFixed(2));

						val = "$" + val;
						$(this).children().children('#total_value').text(val);
						global_pause = false;
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
                                                updateTable(row, price, symbol);
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
