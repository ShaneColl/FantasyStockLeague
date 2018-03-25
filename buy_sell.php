<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset="UTF-8">
		<title>Fantasy Stock League</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
		<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
		<link rel="stylesheet" href="css/style.css">
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
		<div class = "container-fluid">
			<div class = "well outter-well" id="num1">
				<h1 class = "text-center" style="font-size:50px;"><strong>Buy/Sell Table</strong></h1>
			<form id="searchForm" action="search" method="post">
				Search Company:<br>
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
		</script>




		<script>
		var table_rows = []
		$(document).ready( function () {
			$('#main_table').DataTable();

			// <?php
			// $mysqli = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
			// if (mysqli_connect_errno())
			//   {
			//   echo "Failed to connect to MySQL: " . mysqli_connect_error();
			//   }
			// $player_Email = "fakeemail@email.com";
			// $GM_Email = "ddd@test.com";
			// $session_name = "tester_game";
			// $querystring = "SELECT * FROM session_data WHERE owner = '" . $player_Email . "' and email_GM = '" . $GM_Email . "' and session_name = '" . $session_name . "'";
			// $result = $mysqli->query($querystring);
			// if (!$result) {
			// 	echo 'Could not run query: ' . mysqli_error();
			// }
			// while( $row = mysqli_fetch_assoc($result)) {
			// 	?>
			// 	var Tstockticker = "<?php echo $row['stock_ticker'] ?>";
			// 	var Tprice = "<?php echo $row['price'] ?>";
			// 	var Tnumber = "<?php echo $row['number'] ?>";
			// 	var entry = {company: Tstockticker, price: Tprice, number: Tnumber};
			// 	table_rows.push(entry);
			// 	<?php
			// }
			// mysqli_close($mysqli);
			// ?>
			// var arrayLength = table_rows.length;
			// for (var i = 0; i < arrayLength; i++) {
			// 	var outsideObj = (table_rows[i]);
			// 	var outsideCompany = outsideObj.company;
			// 	var total_number = outsideObj.number;
			// 	for (var j = 0; j < arrayLength; j++){
			// 		var insideObj = (table_rows[j]);
			// 		var insideCompany = insideObj.company;
			// 		if (j != i && outsideCompany == insideCompany){ //don't want to count same company stock purchase/sell twice
			// 			total_number += insideObj.number;
			// 		}
			// 	}
			// 	if (total_number > 0){
			// 		var finalObj = {company: outsideCompany, price: outsideObj.price, number: total_number}; //price is wrong. need to grab current price from API
			// 		PopulateTable(finalObj);
			// 	}
			// }
		} );

		//PUT LOGIC FOR API IN THIS FUNCTION. THIS IS FOR CREATING NEW ROWS. Need current price from API.
		function PopulateTable(obj){
				var rowData = [];
				var table = $('#main_table').DataTable();
				var db_data1 = obj.company //stock ticker name
				var db_data2 = "$"+obj.price //current individual stock value
				var db_data3 = "$"+(parseInt(obj.number) * parseFloat(obj.price)); //total value
				var db_data4 = obj.number; //this is the amount of stock currently owned by player. set to 0 if no stock owned
				rowData.push('<button type="button" class="dt-delete"> Delete</button>');
				rowData.push('<p id="stock_ticker">'+ db_data1 +'</p>');
				rowData.push('<p id="value">'+ db_data2 +'</p>');
				rowData.push('<p id="total_value">'+ db_data3 +'</p>');
				rowData.push(   ' <input id="amount" type="text" value="'+db_data4+'" size="10"/>'+
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
			var price = $(this).parents('tr').children().children('#value').text().substring(1,$(this).parents('tr').children().children('#value').text().length);
			console.log(price);

			// price = Math.round10(price, -2);
			// console.log(price);
			var val = parseInt(amount)*parseFloat(price);
			val = (val).toFixed(2);
			//val = parseFloat(val);
			console.log(val);
			//$(this).parents('tr').children().children('#total_value').text("$"+parseInt(amount)*parseFloat(price));
			$(this).parents('tr').children().children('#total_value').text("$"+val);
		});

		$('#main_table').on('click', ".down_button", function(evt){
			$(this).parents('tr').children().children('#amount').val(parseInt($(this).parents('tr').children().children('#amount').val())-1);
			var amount = $(this).parents('tr').children().children('#amount').val();
			var price = $(this).parents('tr').children().children('#value').text().substring(1,$(this).parents('tr').children().children('#value').text().length);
			var val = parseInt(amount)*parseFloat(price);
			val = (val).toFixed(2);
			$(this).parents('tr').children().children('#total_value').text("$"+val);
		});

		$('#num1').on('click', ".transaction", function(evt){
			var table = $('#main_table');
			var row = table.children('tbody');
			row.children().each(function () {
				var ticker = $(this).children().children('#stock_ticker').text();
				var value = $(this).children().children('#value').text();
				var total_value = $(this).children().children('#total_value').text();
				var amount = $(this).children().children('#amount').val();
				alert(amount);
				alert(ticker);

				$.ajax({
				  type: 'POST',
				  url: 'buy_sell_dbInsert.php',
				  data: {'ticker': ticker, 'value': value, 'total_value': total_value, 'amount': amount},
				});
			});
		});

		</script>




		<!-- //Live updating
		<script>

		    var previous = null;
		    var current = null;
		    setInterval(function() {



					var table = $('#main_table').DataTable();
					var data = table.data().toArray();
					var tableRows = Object.keys(data).length;
					for( i = 0; i < tableRows; i++) {
		        $.getJSON("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol="+ $(data[i][1]).text() +"&interval=1min&apikey=57FPBKMUD9NS4AAH", function(json) {

		          //Making sure the correct Json file is received
		          if(json.hasOwnProperty('Meta Data')) {
		            var metaData = json["Meta Data"];
		            var metaDataObject = Object.keys(metaData);
		            var symbol = metaData[metaDataObject[1]];
		            console.log("Symbol: " + symbol);

		            var priceTimeSeries = json["Time Series (1min)"];
		            var priceTimeSeriesObject = Object.keys(priceTimeSeries);
		            //Sets price equal to the most recent closing price.
		            var price = parseFloat(priceTimeSeries[priceTimeSeriesObject[0]]["4. close"]);
		            console.log(price);






		            // current = JSON.stringify(json);
		            // console.log(current);
		            // console.log("running");
		            // if (previous && current && previous !== current) {
		            //     console.log('refresh');
		            //     location.reload();
		            // }
		            // previous = current;
		          }

		        });
		    }, 2000);//Every 3 seconds

		    </script> -->



</body>
