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

		//Search bar test
		<div id="search">
	  <input id="term" type="text" value="enter your search" />
	  <button id="hit" type="button" name="">Search</button>
	</div>

		<div class = "container-fluid">
			<div class = "well outter-well" id="num1">
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
				<button type="button" data-func="dt-add" class="btn-md button-new dt-add"> Add Row </button>
			</div>
			<div class = "row">
				<div class = "col-md-2 col-md-2">
					<a class="btn-md button-new ubuntu-font" href="userHub.html">Back to Game Hub</a>
				</div>
			</div>
		</div>




		<script>
		var companyNames = []
		$(document).ready( function () {
			$('#main_table').DataTable();

			// <?php
			// $mysqli = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
			// if (mysqli_connect_errno())
			//   {
			//   echo "Failed to connect to MySQL: " . mysqli_connect_error();
			//   }
			// $playerEmail = "fakeemail@email.com";
			// $querystring = "SELECT * FROM session_data WHERE owner = '" . $playerEmail . "'";
			// $result = $mysqli->query($querystring);
			// if (!$result) {
			// 	echo 'Could not run query: ' . mysqli_error();
			// }
			// ?>
			// <?php
			// while( $row = mysqli_fetch_assoc($result)) {
			// 	$companyName = $row['stock_ticker'];
			// 	?>
			// 	companyNames.push('<?php echo $companyName;  ?>');
			// 	<?php
			// }
			// ?>
			// var arrayLength = companyNames.length;
			// for (var i = 0; i < arrayLength; i++) {
			// 	PopulateTable(companyNames[i]);
			// }
		} );

		function PopulateTable(companyName, price){



				var rowData = [];
				var table = $('#main_table').DataTable();
				var db_data1 = companyName //stock ticker name
				var db_data2 = '$ ' + price; //current individual stock value
				var db_data3 = '$0' //total value
				var db_data4 = '0' //this is the amount of stock currently owned by player. set to 0 if no stock owned
				rowData.push('<button type="button" data-func="dt-add" class="dt-delete"> Delete</button>');
				rowData.push(db_data1);
				rowData.push(db_data2);
				rowData.push(db_data3);
				rowData.push(db_data4);
				table.row.add(rowData).draw( false );

				var data = table.data().toArray();
				console.log(data);
				var tableRows = Object.keys(data).length;
				//console.log("data length " + Object.keys(data).length);
				console.log(tableRows);
				for( i = 0; i < tableRows; i++) {
				console.log("Entry at row: " + i + " "+ data[i][1]);
			}
				//console.log(data[0][1]);

		}

		$('.dt-add').each(function () {
			$(this).on('click', function(evt){
				//Create some data and insert it
				var rowData = [];
				var table = $('#main_table').DataTable();
				var db_data1 = 'GOOGL' //stock ticker name
				var db_data2 = '$5' //current individual stock value
				var db_data3 = '$20' //total value
				var db_data4 = '5' //this is the amount of stock currently owned by player. set to 0 if no stock owned
				rowData.push('<button type="button" data-func="dt-add" class="dt-delete"> Delete</button>');
				rowData.push(db_data1);
				rowData.push(db_data2);
				rowData.push(db_data3);
				rowData.push(db_data4);
				table.row.add(rowData).draw( false );
			});
		});

		$('#main_table').on('click', ".dt-delete", function(evt){
			var table = $('#main_table').DataTable();
			table.row($(this).parents('tr')).remove().draw( false );
		});
		</script>


		<script>
		function test(q) {
			console.log("entering test");
			$.getJSON("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=" + q +"&interval=1min&apikey=57FPBKMUD9NS4AAH", function(json) {
				console.log("fetched api")
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

								PopulateTable(symbol, price);
				}
		});
		}
		</script>

		<script>
		$(document).ready(function() {
		$('#hit').click(function() {
			var stock = $('#term').val();
			//alert($('#term').val());
			test(stock);
		});
		});
		</script>


</body>
