var nvd3Charts = function() {
	
        var myColors = ["#8DCA35","#00BFDD","#FF702A","#DA3610",
                        "#80CDC2","#A6D969","#D9EF8B","#FFFF99","#F7EC37","#F46D43",
                        "#E08215","#D73026","#A12235","#8C510A","#14514B","#4D9220",
                        "#542688", "#4575B4", "#74ACD1", "#B8E1DE", "#FEE0B6","#FDB863",                                                
                        "#C51B7D","#DE77AE","#EDD3F2","#33414E"];
        d3.scale.myColors = function() {
            return d3.scale.ordinal().range(myColors);
        };

   
    
	var findMin = function(data){
    	var min_val = parseFloat(data[0].values[0][1]);
		for (var i = data[0].values.length - 1; i >= 0; i--) {
			if ((min_val > parseFloat(data[0].values[i][1]))){
				min_val = parseFloat(data[0].values[i][1])-0.5;
			}	
		};
		min_val = Math.round(min_val);
		return min_val;
    }

    var findMax = function(data){
    	var max_val = parseFloat(data[0].values[0][1]);
		for (var i = data[0].values.length - 1; i >= 0; i--) {
			if ((max_val < parseFloat(data[0].values[i][1]))){
				max_val = parseFloat(data[0].values[i][1])+0.5;
			}	
		};
		max_val = Math.round(max_val);
		return max_val;
    }

    var startChart = function(id,color,url) {

		d3.json(url, function(data) {
			var min = d3.min(data[0].values, function(d) { return +d[1]; });
            var max = d3.max(data[0].values, function(d) { return +d[1]; });
	
			nv.addGraph(function() {

				var chart = nv.models.lineChart().x(function(d) {
					return d[0]*1000;
				}).y(function(d) {
					return d[1] ;
				})
				.color([color])
				.useInteractiveGuideline(true);


                chart.xAxis.tickFormat(function(d) {
                        return d3.time.format('%c')(new Date(d));
                });
                chart.yAxis.tickFormat(d3.format(',.1f'));

                chart.yDomain([min, max]);
				d3.select(id).datum(data).call(chart);
				nv.utils.windowResize(chart.update);

				return chart;
			});
		});
	};

	var startCharTemperature = function(mode) {
		var url = 'api/data.php?m='+mode;
		var color = "#8DCA35";
		var id = '#chart-temperature svg';
		startChart(id,color,url);
	};
	var startCharTemperatureIndoor = function(mode) {
		var url = 'api/data.php?t=T0&m='+mode;
		var color = "#FAA200";
		var id = '#chart-temperature-indoor svg';
		startChart(id,color,url);

	};
	var startCharHumidity = function(mode) {
		var url = 'api/data.php?t=H1&m='+mode;
		var color = "#00BFDD";
		var id = '#chart-humidity svg';
		startChart(id,color,url);	
	};
	var startCharHumidityIndoor = function(mode) {
		var url = 'api/data.php?t=H0&m='+mode;
		var color = "#B0F6FF";
		var id = '#chart-humidity-indoor svg';
		startChart(id,color,url);	
	};

	var startCharWindspeed = function(mode) {
		var url = 'api/data.php?t=WS&r=100&m='+mode;
		d3.json(url, function(data) {
	
			nv.addGraph(function() {

				var chart = nv.models.discreteBarChart().x(function(d) {
					return d[0]*1000;
				}).y(function(d) {
					return d[1] ;
				})
				.staggerLabels(true)
				.color(["#DA3610"]);


                chart.xAxis.tickFormat(function(d) {
                        return d3.time.format('%c')(new Date(d));
                });

                chart.yDomain([findMin(data), findMax(data)]);
				d3.select('#chart-windspeed svg').datum(data).call(chart);
				nv.utils.windowResize(chart.update);

				return chart;
			});
		});
	};

	var startCharUv = function(mode) {
		var url = 'api/data.php?t=UV&r=100&m='+mode;
		var color = "#00BFDD";
		var id = '#chart-uv svg';
		startChart(id,color,url);
	};
	


	return {		
		init : function(mode) {
			mode = mode || 2;
			startCharTemperature(mode);
			startCharHumidity(mode);
			startCharWindspeed(mode);
			startCharUv(mode);
			startCharTemperatureIndoor(mode);
			startCharHumidityIndoor(mode);
		}
	};
}();

