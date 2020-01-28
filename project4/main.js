window.onload = function () {
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light1", // "light2", "dark1", "dark2"
	animationEnabled: false, // change to true		
	title:{
		text: "Basic Column Chart"
	},
	data: [
	{
		// Change type to "bar", "area", "spline", "pie",etc.
		type: "column",
		dataPoints: [
		
			{ label: nazwy[0],  y: parseInt(uczestnicy[0])  },
			{ label: nazwy[1], y: parseInt(uczestnicy[1])  }
			
		]
	}
	]
});
chart.render();

}
var a = 1;

