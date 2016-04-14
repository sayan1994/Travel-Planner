$(function(){

	var $input = $('#place');
	console.log("lol");

	var urls = new Array(13);

	$('#submit').on('click',function(){
		console.log("hi");
		var i,j;

		// WEATHER DATA LOAD
		for (i = 1; i <= 12 ; i++) {

		   $url = "http://api.worldweatheronline.com/premium/v1/past-weather.ashx?key=d3ef6204a5b04dcc814175928162103&q=" + $input.val();
		   $url1 = "&format=json&date=2014-09-01&enddate=2014-09-29&tp=24";

		   if(i == 2){
		   		$url1 = "&format=json&date=2015-02-01&enddate=2015-02-28&tp=24";
		   }
		   else if(i == 1 || i == 3 || i == 5 || i == 7 || i == 8 || i == 10 || i == 12){
		   		if(i<10){
		   			$url1 = "&format=json&date=2015-0"+i+"-01&enddate=2015-0"+i+"-31&tp=24";
		   		}
		   		else{
		   			$url1 = "&format=json&date=2015-"+i+"-01&enddate=2015-"+i+"-31&tp=24";
		   		}
		   }
		   else
		   {
		   	    if(i == 11){
		   	    	$url1 = "&format=json&date=2015-"+i+"-01&enddate=2015-"+i+"-30&tp=24";
		   	    }
		   	    else{
		   	    	$url1 = "&format=json&date=2015-0"+i+"-01&enddate=2015-0"+i+"-30&tp=24";
		   	    }
		   }
		   
		   $url = $url + $url1;
		   $url = $url.replace(" ","%20");
		   console.log($url);

		   urls[i] = $url;
		}

		for (var i = 1; i <=12; i++) {

		    (function(i) { // protects i in an immediately called function
		    	var month = i;
				$.getJSON(urls[i], function(data1) {
					console.log(data1);

					var $name = $input.val();
					var max_temp = -1000;
					var min_temp = 1000;
					var average_temp = 0;
					var average_humidity = 0;
					var average_precipitation = 0;
					var windspeed = 0;
					// var $month = i;

					console.log("month = "+month);

					if(month == 2){

						for(j=0 ; j < 28 ; j++){
							average_temp += parseInt(data1.data.weather[j].hourly[0].tempC);
							average_humidity += parseInt(data1.data.weather[j].hourly[0].humidity);
							windspeed += parseInt(data1.data.weather[j].hourly[0].windspeedKmph);
							average_precipitation += parseInt(data1.data.weather[j].hourly[0].precipMM);

							if(max_temp < parseInt(data1.data.weather[j].maxtempC)){
								max_temp = parseInt(data1.data.weather[j].maxtempC);
							}

							if(min_temp > parseInt(data1.data.weather[j].mintempC)){
								min_temp = parseInt(data1.data.weather[j].mintempC);
							}
						}

						average_temp /= 28;
						average_humidity /= 28;
						windspeed /= 28;
						average_precipitation /= 28;

					}
					else if(month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12){
						for(j=0 ; j < 31 ; j++){

							average_temp += parseInt(data1.data.weather[j].hourly[0].tempC);
							average_humidity += parseInt(data1.data.weather[j].hourly[0].humidity);
							windspeed += parseInt(data1.data.weather[j].hourly[0].windspeedKmph);
							average_precipitation += parseInt(data1.data.weather[j].hourly[0].precipMM);

							if(max_temp < parseInt(data1.data.weather[j].maxtempC)){
								max_temp = parseInt(data1.data.weather[j].maxtempC);
							}

							if(min_temp > parseInt(data1.data.weather[j].mintempC)){
								min_temp = parseInt(data1.data.weather[j].mintempC);
							}
						}
						average_temp /= 31;
						average_humidity /= 31;
						windspeed /= 31;
						average_precipitation /= 31;
					}
					else
					{
						 for(j=0 ; j < 30 ; j++){
						 	average_temp += parseInt(data1.data.weather[j].hourly[0].tempC);
							average_humidity += parseInt(data1.data.weather[j].hourly[0].humidity);
							windspeed += parseInt(data1.data.weather[j].hourly[0].windspeedKmph);
							average_precipitation += parseInt(data1.data.weather[j].hourly[0].precipMM);

							if(max_temp < parseInt(data1.data.weather[j].maxtempC)){
								max_temp = parseInt(data1.data.weather[j].maxtempC);
							}

							if(min_temp > parseInt(data1.data.weather[j].mintempC)){
								min_temp = parseInt(data1.data.weather[j].mintempC);
							}
						 }

						 average_temp /= 30;
						 average_humidity /= 30;
						 windspeed /= 30;
						 average_precipitation /= 30;
					}

					var txt0 = document.createElement("p");
					txt0.innerHTML = "MONTH ==> "+month+" and place ==> "+$name;

					var txt1 = document.createElement("p");
					txt1.innerHTML = "MAX TEMP of "+$name+" ==> "+max_temp;

					var txt2 = document.createElement("p");
					txt2.innerHTML = "MIN TEMP of "+$name+" ==> "+min_temp;

					var txt3 = document.createElement("p");
					txt3.innerHTML = "Average Temp of "+$name+" ==> "+average_temp;

					var txt4 = document.createElement("p");
					txt4.innerHTML = "Average Humidity of "+$name+" ==> "+average_humidity;

					var txt5 = document.createElement("p");
					txt5.innerHTML = "Average windspeed of "+$name+" ==> "+windspeed;

					var txt6 = document.createElement("p");
					txt6.innerHTML = "Average precipitation of "+$name+" ==> "+average_precipitation;

					$('#first').append(txt0,txt1,txt2,txt3,txt4,txt5,txt6);


					$.ajax(
				      {
				        url: "weather_sql_insert.php",
				        type:"post",
				        dataType:"json",
				        data:
				        {
				        	name:$name,
				            month:month,
				            max_temp:max_temp,
				            min_temp:min_temp,
				            average_temp:average_temp,
				            average_humidity:average_humidity,
				            average_precipitation:average_precipitation,
				            windspeed:windspeed
				        },

				        success: function(json)
				        {
				           alert(json.status);
				        },

				        error : function()
				        {
				          alert("ERROR");
				        }
				      });

				});
		    })(i);
		}
	});
});