
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);


const graficoDiv = document.getElementById('grafico');
const chartData = JSON.parse(graficoDiv.dataset.datos);

console.log(chartData   )
    // Your Function
    function drawChart() {
        // Set Data
        const data = google.visualization.arrayToDataTable(chartData);



// Set Options
        const options = {
            title: 'World Wide Wine Production'
        };

// Draw
        const chart = new google.visualization.PieChart(document.getElementById('myChart'));
        chart.draw(data, options);


}
