<!DOCTYPE html>
<html lang = "en">
<head>
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

  <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
</head>

<body>

  <div id="chartContainer" style="height: 370px; width: 100%;"></div>
  <div class = "container-fluid">
			<div class = "well outter-well" id="num1">

        <form action="userHub.php" method="get" style="padding-left: 2.5%;">


        <div class="row">
          <button class="btn button-new col-xs-3" type="submit">Back to Game Hub</button>
          </div>
          </form>


				<h1 class = "text-center" style="font-size:50px;"><strong>TransactionHistory</strong></h1>
				<div class = "well well-sm" id="num2">
    <table id="main_table" class="display">
          <thead>
            <tr>
              <th>Date</th>
              <th>Stock</th>
              <th>ValuePerStock</th>
              <th>Amount Purchased</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
  </div>
  <div class = "row">
      <div class = "col-md-2 col-md-2">
        <a class="btn-md button-new ubuntu-font" href="userHub.php">Back to Game Hub</a>
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

  function addMoneyToMap(map, date, money){

    if(map.has(date)){
      var m = map.get(date);
      m += money;
      map.set(date, m);
    }
    else {
      //addMoneyFromStartingCashMap
      map.set(date, money);
    }
  }

  // function addMoneyToMap(map, date, money, initial_cash){
  //
  //   if(map.has(date)){
  //     var m = map.get(date);
  //     m += money;
  //     map.set(date, m);
  //   }
  //   else {
  //
  //     map.set(date, money + initial_cash);
  //   }
  // }

//Key will be the date and the value will be the money the user has on that date.
 var strDateToMoney = new Map();
 var dateToMoney = new Map();

 var stockToDate = new Map();
 var stockAndDateToQuantity = new Map();
 var dateToMoney2 = new Map();

  var dateOfTransactions = [];
  var mapDateToTransactionHistory = new Map();

  var start_date;
  var initial_cash;


   <?php
   $mysqli = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
   if (mysqli_connect_errno())
   {
     echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }


   //Query SessionList get starting cash



   $player_Email = $email;
   $GM_Email = $GM_Email;
   $session_name = $session_name;



      //Intial_cash and start date
      $querystring = "SELECT * FROM session_list WHERE email_GM = '" . $GM_Email . "' and session_name = '" . $session_name . "'";
      $result = $mysqli->query($querystring);
      if (!$result) {
          echo 'Could not run query: ' . mysqli_error();
         }


      while($row = mysqli_fetch_assoc($result)) {
        ?>
        start_date = "<?php echo $row['start_date']; ?>";
        initial_cash = "<?php echo $row['start_cash']; ?>";
        addMoneyToMap(strDateToMoney, start_date, parseFloat(initial_cash));

        <?php
      }



   $querystring = "SELECT * FROM session_data WHERE owner = '" . $email . "' and email_GM = '" . $GM_Email . "' and session_name = '" . $session_name . "'";
   $result = $mysqli->query($querystring);
   if (!$result) {
       echo 'Could not run query: ' . mysqli_error();
      }




   while( $row = mysqli_fetch_assoc($result)) {
   ?>
   console.log("Loop entered");
    var stockName = "<?php echo $row['stock_ticker'] ?>";
    var stockPrice = "<?php echo $row['price'] ?>";
    var stockNumber = "<?php echo $row['number'] ?>";
    var date = "<?php echo $row['date'] ?>";

     console.log("stock: " + stockName);
     console.log("Stockprice: " + stockPrice);
     console.log("StockNumber: " + stockNumber);
     console.log("date: " + date);

     var temp = new Date(date);
     var tempArr = [];
     tempArr.push(stockName);
     tempArr.push(stockPrice);
     tempArr.push(stockNumber);
     dateOfTransactions.push(temp);
     mapDateToTransactionHistory.set(temp, tempArr);


     if(stockToDate.has(stockName)){
      var t = stockToDate.get(stockName);
      t.push(temp);
      stockToDate.set(stockName, t);

      var sentinel = stockName + temp.toISOString().split('T')[0];
      if(stockAndDateToQuantity.has(sentinel)){
        var b = stockAndDateToQuantity.get(sentinel);
        b += stockNumber;
        stockAndDateToQuantity.set(sentinel, b);

      }
     }
     else {
       var tempDates = [];
       tempDates.push(temp);
       stockToDate.set(stockName, tempDates);

       var sentinel = stockName + temp.toISOString().split('T')[0];
       stockAndDateToQuantity.set(sentinel, stockNumber);

     }
    //converts date from string to date
    // var date = new Date(date);

     var incrementMoney = parseFloat(stockPrice) * parseFloat(stockNumber);
     incrementMoney = incrementMoney * -1;
     //addMoneyToMap(dateToMoney, date, incrementMoney, initial_cash);
     addMoneyToMap(strDateToMoney, date, incrementMoney);
    // addTransactionHistory(mapDateToTransactionHistory, datestock)
     <?php
   }
  mysqli_close($mysqli);
  ?>
  console.log(strDateToMoney);

  console.log("Date to Transaction: " + mapDateToTransactionHistory);

  var dates = [];
  var keyIterater = strDateToMoney.keys();

  for(let i of keyIterater){
    var temp = new Date(i);
    dates.push(temp);
    dateToMoney.set(temp, strDateToMoney.get(i));
  }

  var sortDates = function(d1, d2){
    if(d1 > d2) return 1;
    else if(d2 > d1) return -1;
    else return 0;
  }

  console.log(dates);
  dates.sort(sortDates);

  console.log(dates);

  function dPNetWorthAfterTransaction(orderedDates,dateToMoney){
    for(let i = 1; i < orderedDates.length; i++) {
      dateToMoney.set(orderedDates[i], ( dateToMoney.get(orderedDates[i - 1]) + dateToMoney.get(orderedDates[i]) ) );
    }

  }

  dPNetWorthAfterTransaction(dates, dateToMoney);



// function populateNetWorthMap(stock, date, stockAndDateToQuantity, price, dateToMoney2){
//     if(dateToMoney2.has(date.toISOString().split('T')[0])){
//       var t = stockAndDateToQuantity.get(stock+date.toISOString().split('T')[0]);
//       var t = t * price;
//       var temp = dateToMoney2.get(date.toISOString().split('T')[0]);
//       temp += t;
//
//       dateToMoney2.set(date.toISOString().split('T')[0], temp);
//
//     }
//
//     else{
//       var t = stockAndDateToQuantity.get(stock+date.toISOString().split('T')[0]);
//       var t = t * price;
//       dateToMoney2.set(date.toISOString().split('T')[0], t);
//     }
//
//     //console.log("date to money2: " + dateToMoney2);
// }
//
//
// function APICall(stock, dateList, stockAndDateToQuantity, dateToMoney2){
//
//
//   $.getJSON("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=" + stock +"&interval=1min&apikey=57FPBKMUD9NS4AAH", function(json) {
//     console.log("fetched api");
//     console.log(json);
//     if(json.hasOwnProperty('Meta Data')) {
//     var metaData = json["Meta Data"];
//     var metaDataObject = Object.keys(metaData);
//     var symbol = metaData[metaDataObject[1]];
//   //	console.log("Symbol: " + symbol);
//
//             var priceTimeSeries = json["Time Series (Daily)"];
//             var priceTimeSeriesObject = Object.keys(priceTimeSeries);
//             //Sets price equal to the most recent closing price.
//             // console.log(priceTimeSeriesObject[0]);
//             // console.log(priceTimeSeries[priceTimeSeriesObject[0]]);
//             //var date = new Date("2018-04-16 16:00:00");
//             console.log(dateList);
//             for(let i = 0; i < dateList.length; i++) {
//           //  console.log(priceTimeSeries["2018-04-16"]["4. close"]);
//               var date = dateList[i];
//               var d = date.toISOString().split('T')[0];
//               // console.log(d);
//               // console.log(priceTimeSeries[d]["4. close"]);
//               var price = parseFloat(priceTimeSeries[d]["4. close"]);
//               console.log(symbol + "price: " + price + "date: " + d);
//               populateNetWorthMap(stock, date, stockAndDateToQuantity, price, dateToMoney2);
//           }
//             //populateNetWorthMap(stock, dateList, stockAndDateToQuantity);
//
//           }
//
//       });
// }




  //
  // function queryAPI(stockToDate, stockAndDateToQuantity, dateToMoney2){
  //   var keys = stockToDate.keys();
  //   for(let i of keys){
  //     var d = stockToDate.get(i);
  //     APICall(i, d, stockAndDateToQuantity, dateToMoney2);
  //   }
  //
  //   //var o = makeNetWorthObject(dateToMoney2);
  //   //drawNetWorthGraph(o);
  // }

//queryAPI(stockToDate, stockAndDateToQuantity, dateToMoney2);




  function drawGraph(options){
    $(document).ready(function() {
    $("#chartContainer").CanvasJSChart(options);

    console.log(options);
    function toogleDataSeries(e){
    	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    		e.dataSeries.visible = true;
    	} else{
    		e.dataSeries.visible = true;
    	}
    	e.chart.render();
    }

  });
  }

  function makeOptions(dates, dateToMoney){

    var data = [];
    for(let i = 0; i < dates.length; i++){
      data.push({x: dates[i], y: dateToMoney.get(dates[i])});
    }

    console.log("data: " + data);
    var options = {
     animationEnabled: true,
     theme: "light2",
     title:{
       text: "Liquidity"
     },
     axisX:{
      // valueFormatString: "DD MMM"
      valueFormatString: "YYYY-MM-DD HH:mm:ss"
      //valueFormatString: "Y-m-d h:i:s"

     },
     axisY: {
       title: "Liquidity change over time",
       prefix:"$",
       //minimum: 0

     },
     toolTip:{
       shared:true
     },
     legend:{
       cursor:"pointer",
      // verticalAlign: "bottom",
      // horizontalAlign: "left",
       //dockInsidePlotArea: true,
       //    itemclick: toogleDataSeries
     },
     data: [{
       type: "line",
       showInLegend: true,
       name: "Liquidity after Transaction",
       markerType: "square",
       //xValueFormatString: "YYYY-MM-DD HH:mm:ss",
       xValueFormatString: "YYYY-MM-DD",
       color: "#F08080",
       yValueFormatString: "$#",
       dataPoints: [
         // { x:10-01-2017, y: 63 },
         //      { x: new Date(2017, 10, 2), y: 69 },
         //      { x: new Date(2017, 10, 3), y: 65 },
         //      { x: new Date(2017, 10, 4), y: 70 },
         //      { x: new Date(2017, 10, 5), y: 71 },
       ]
     }
    ]
    };
    // console.log("options: " + options);
    // console.log("options points: " + options.data[0].dataPoints);
     options.data[0].dataPoints = data;
    // console.log("options points: " + options.data[0].dataPoints);

    drawGraph(options);

   }
  makeOptions(dates, dateToMoney);




  function populateTable(dateArray, mapDateToTransactions){
  $(document).ready(function() {
    var table = $('#main_table').DataTable();
    for(let i = 0; i < dateArray.length; i++ ){
      var rowData = [];
      rowData.push('<p>' + dateArray[i] +'</p>');

      var mapRowDate = mapDateToTransactions.get(dateArray[i]);
      rowData.push('<p>' + mapRowDate[0] + '</p>');
      rowData.push('<p>' + mapRowDate[1] + '</p>');
      rowData.push('<p>' + mapRowDate[2] + '</p>');

      table.row.add(rowData).draw(false);
    }

  });
  }

  //Display transaction history
  dateOfTransactions.sort(sortDates);
  console.log("Sorted transactions: " + dateOfTransactions);
  for( let i = 0; i < dateOfTransactions.length; i++){
   console.log("transaction: " + mapDateToTransactionHistory.get(dateOfTransactions[i]));
   // var temp = mapDateToTransactionHistory.get(dateOfTransactions[i]);
   // for(let j = 0; j < temp.length; j++){
   //   console.log("transaction: " + temp[j]);
   // }
  }

  populateTable(dateOfTransactions, mapDateToTransactionHistory);


  // var netWorthPerDay = dates;
  // netWorthPerDay.splice(0, 0, )





  </script>





<script>

//
</script>
</body>
