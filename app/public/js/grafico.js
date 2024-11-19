google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    const graficoDiv = document.getElementById('grafico');

    const datosPreguntas = JSON.parse(graficoDiv.dataset.datos).graficoPreguntas;
    const datosJugadores = JSON.parse(graficoDiv.dataset.datos).graficoJugadores;
    const datosPartidas = JSON.parse(graficoDiv.dataset.datos).graficoPartidas;
    const datosEdad = JSON.parse(graficoDiv.dataset.datos).graficoEdad;
    const datosPorcentaje = JSON.parse(graficoDiv.dataset.datos).graficoPorcentaje;

    const dataPreguntas = google.visualization.arrayToDataTable(datosPreguntas);
    const dataJugadores = google.visualization.arrayToDataTable(datosJugadores);
    const dataPartidas = google.visualization.arrayToDataTable(datosPartidas);
    const dataEdad = google.visualization.arrayToDataTable(datosEdad);
    const dataPorcentaje = google.visualization.arrayToDataTable(datosPorcentaje);

    const optionsPreguntas = {
        title: 'Preguntas del Último Año',
    };

    const optionsJugadores = {
        title: 'Jugadores del Último Año',
    };

    const optionsPartidas = {
        title: 'Jugadores del Último Año',
    };

    const optionsEdad = {
        title: 'Edad de Jugadores del Último Año',
    };

    const optionsPorcentaje = {
        title: 'Respuestas correctas del Último Año',
    };


    const chartPreguntas = new google.visualization.PieChart(document.getElementById('graficoPreguntas'));
    chartPreguntas.draw(dataPreguntas, optionsPreguntas);

    const chartJugadores = new google.visualization.PieChart(document.getElementById('graficoJugadores'));
    chartJugadores.draw(dataJugadores, optionsJugadores);

    const chartPartidas = new google.visualization.PieChart(document.getElementById('graficoPartidas'));
    chartPartidas.draw(dataPartidas, optionsPartidas);

    const chartEdad = new google.visualization.PieChart(document.getElementById('graficoEdad'));
    chartEdad.draw(dataEdad, optionsEdad);

    const chartPorcentaje = new google.visualization.PieChart(document.getElementById('graficoPorcentaje'));
    chartPorcentaje.draw(dataPorcentaje, optionsPorcentaje);
}