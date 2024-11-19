google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    const graficoDiv = document.getElementById('grafico');
    const datos = JSON.parse(graficoDiv.dataset.datos).graficoUsuarios;

    // Crear los datos para Google Charts
    const data = google.visualization.arrayToDataTable(datos);

    // Opciones para el gráfico
    const options = {
        title: 'Estadísticas del Último Año',
        pieHole: 0.4,
        width: 400,
        height: 300,
    };

    // Dibujar el gráfico
    const chart = new google.visualization.PieChart(document.getElementById('myChart'));
    chart.draw(data, options);
}