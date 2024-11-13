// This function will be executed when the document is fully loaded and ready
$(document).ready(function(){
    // Call the lineChart, donutChart, and pieChart functions
    lineChart();
    donutChart();
    pieChart();

    // This event listener will trigger when the window is resized
    $(window).resize(function(){
        // Redraw the line chart, donut chart, and pie chart when the window is resized
        window.lineChart.redraw();
        window.donutChart.redraw();
        window.pieChart.redraw();
    });
});

// Function to create a line chart using Morris.js
function lineChart(){
    // Define the line chart using Morris.js
    window.lineChart = Morris.Line({
        // Specify the HTML element to render the chart
        element: 'line-chart',
        // Data for the chart
        data: [
            {y: '2006', a: 100, b: 90},
            {y: '2007', a: 75, b: 65},
            {y: '2008', a: 50, b: 40},
            {y: '2009', a: 75, b: 65},
            {y: '2010', a: 50, b: 40},
            {y: '2011', a: 75, b: 65},
            {y: '2012', a: 100, b: 90}
        ],
        // Define the x-axis key
        xkey: 'y',
        // Define the y-axis keys
        ykeys: ['a', 'b'],
        // Labels for the data series
        labels: ['Series A', 'Series B'],
        // Colors for the lines in the chart
        lineColors: ['#710827', '#cdc6c6'],
        // Width of the lines
        lineWidth: '3px',
        // Enable auto-resizing of the chart
        resize: true,
        // Allow redrawing of the chart
        redraw: true
    });
}

// Function to create a donut chart using Morris.js
function donutChart(){
    // Define the donut chart using Morris.js
    window.donutChart = Morris.Donut({
        // Specify the HTML element to render the chart
        element: 'donut-chart',
        // Data for the chart
        data: [
            {label: "Normal Room", value: 50},
            {label: "Ac Room", value: 25},
            {label: "Special Room", value: 5},
            {label: "DoubleBed room", value: 10},
            {label: "Video Room", value: 10},
        ],
        // Background color for the chart
        backgroundColor: '#710827',
        // Color for the labels
        labelColor: '#710827',
        // Colors for the segments of the donut
        colors: ['#710827', '#7f213d', '#e3ced4', '#c69ca9', '#aa6b7d'],
        // Enable auto-resizing of the chart
        resize: true,
        // Allow redrawing of the chart
        redraw: true
    });
}

// Function to create a pie chart using Raphael.js
function pieChart(){
    // Create a Raphael paper object for drawing the pie chart
    var paper = Raphael("pie-chart");
    // Draw the pie chart using the paper.piechart method
    paper.piechart(
        // Specify the center coordinates and radius of the pie chart
        100, 100, 90,
        // Data for the pie chart
        [18.373, 18.686, 2.867, 23.991, 9.592, 0.213],
        // Options for the pie chart
        {
            // Legend for the pie chart
            legend: ["Windows/Windows Live", "Server/Tools", "Online Services", "Business", "Entertainment/Devices", "Unallocated/Other"]
        }
    );
}
