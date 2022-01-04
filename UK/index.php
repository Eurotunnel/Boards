<?php

$url = "https://www.eurotunnel.com/api/v1/departures/GetCombinedBoardResults?terminal=uk";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$token = file_get_contents('http://eurotunnel.tk/token.txt');

$headers = array(
   "Accept: application/json",
   "Authorization: $token
Cache-Control: no-cache",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

$resp = curl_exec($curl);
curl_close($curl);


$var_str = var_export($resp, true);
$var = "$resp";
file_put_contents('eurotunneluk.json', $var);

?>

<!DOCTYPE html>
<html>
    <head>
	   <meta charset="utf-8">
	   <meta name="viewport" content="width=device-width, initial-scale=1">
	   <noscript>Please use a updated browser or allow javascript</noscript>
	   <title>Eurotunnel Boards</title>
	   <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
       <link href="style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
	<script>
	   $(document).ready(function () {
	   
		$.getJSON("eurotunneluk.json", 
				function (data) {
			var letter = '';
			var message = '';
			var time = '';
	   
			$.each(data, function (key, value) {
	   
				letter += '<tr>';
				letter += '<td>' + 
					value.Letter + '</td>';
					
	   
				letter += '</tr>';
			});
			
			$.each(data, function (key, value) {
	   
				message += '<tr>';
				message += '<td>' + 
					value.LinesEn + '</td>';
					
	   
				message += '</tr>';
			});
			
			$.each(data, function (key, value) {
	   
				time += '<tr>';
				time += '<td class=&apos;timejson&apos;>' + 
					value.DepartureTime + '</td>';
					
	   
				time += '</tr>';
			});
			
			$('#BoardL').append(letter);
			$('#BoardM').append(message);
			$('#BoardT').append(time);
		});
	   });
	</script>
        <div class="section wf-section">
            <div class="div-block">
                <div class="w-row">
                    <div class="w-col w-col-4">
                        <h3 class="heading-2">Boarding group</h3>
                    </div>
                    <div class="w-col w-col-4">
                        <h3 class="heading-2">Messages</h3>
                    </div>
                    <div class="w-col w-col-4">
                        <h3 class="heading-2">Departure Time</h3>
                    </div>
                </div>
                <div class="columns w-row">
                    <div class="w-col w-col-4">
                        <table id='BoardL'></table>
                    </div>
                    <div class="w-col w-col-4">
                        <table id='BoardM'></table>
                    </div>
                    <div class="w-col w-col-4"><table id='BoardT'></table><div id="clock">Enable javascript Please</div></div>
                </div>
				</div>
        </div>
		<script>
		   setInterval(showTime, 1000);
		   function showTime() {
			let time = new Date();
			let hour = time.getHours();
			let min = time.getMinutes();
			let sec = time.getSeconds();
			am_pm = "AM";
			 
			if (hour > 12) {
				hour -= 12;
				am_pm = " PM";
			}
			if (hour == 0) {
				hr = 12;
				am_pm = " AM";
			}
			
			hour = hour < 10 ? "0" + hour : hour;
			min = min < 10 ? "0" + min : min;
			sec = sec < 10 ? "0" + sec : sec;
			 
			let currentTime = hour + ":" 
					+ min + ":" + sec + am_pm;
			 
			document.getElementById("clock").innerHTML = currentTime;
		   }
		   showTime();
		</script>

  </body>
</html>
