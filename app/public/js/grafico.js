google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawChart);



function drawChart() {
    const graficoDiv = document.getElementById('grafico');

    const datosPreguntas = JSON.parse(graficoDiv.dataset.datos).graficoPreguntas;
    const datosJugadores = JSON.parse(graficoDiv.dataset.datos).graficoJugadores;
    const datosPartidas = JSON.parse(graficoDiv.dataset.datos).graficoPartidas;
    const datosEdad = JSON.parse(graficoDiv.dataset.datos).graficoEdad;
    const datosPorcentaje = JSON.parse(graficoDiv.dataset.datos).graficoPorcentaje;
    const datosGenero = JSON.parse(graficoDiv.dataset.datos).graficoGenero;
    const datosPais = JSON.parse(graficoDiv.dataset.datos).graficoPais;




    const dataPreguntas = google.visualization.arrayToDataTable(datosPreguntas);
    const dataJugadores = google.visualization.arrayToDataTable(datosJugadores);
    const dataPartidas = google.visualization.arrayToDataTable(datosPartidas);
    const dataEdad = google.visualization.arrayToDataTable(datosEdad);
    const dataPorcentaje = google.visualization.arrayToDataTable(datosPorcentaje);
    const dataGenero = google.visualization.arrayToDataTable(datosGenero);
    const dataPais = google.visualization.arrayToDataTable(datosPais);

    const optionsPreguntas = {
        title: 'Preguntas del Último Año',
    };

    const optionsJugadores = {
        title: 'Jugadores del Último Año',
    };

    const optionsPartidas = {
        title: 'Partidas del Último Año',
    };

    const optionsEdad = {
        title: 'Edad de Jugadores del Último Año',
    };

    const optionsPorcentaje = {
        title: 'Porcentaje de respuestas Último año',
    };

    const optionsGenero = {
        title: 'Porcentaje de generos Último año',
    };
    const optionsPais = {
        title: 'Porcentaje de pais Último año',
    };


    const chartPreguntas = new google.visualization.PieChart(document.getElementById('graficoPreguntas'));
    chartPreguntas.draw(dataPreguntas, optionsPreguntas);
    document.getElementById('variablePreguntas').value=chartPreguntas.getImageURI();


    const chartJugadores = new google.visualization.PieChart(document.getElementById('graficoJugadores'));
    chartJugadores.draw(dataJugadores, optionsJugadores);
    document.getElementById('variableJugadores').value=chartJugadores.getImageURI();

    const chartPartidas = new google.visualization.PieChart(document.getElementById('graficoPartidas'));
    chartPartidas.draw(dataPartidas, optionsPartidas);
    document.getElementById('variablePartidas').value=chartPartidas.getImageURI();

    const chartEdad = new google.visualization.PieChart(document.getElementById('graficoEdad'));
    chartEdad.draw(dataEdad, optionsEdad);
    document.getElementById('variableEdad').value=chartEdad.getImageURI();

    const chartPorcentaje = new google.visualization.PieChart(document.getElementById('graficoPorcentaje'));
    chartPorcentaje.draw(dataPorcentaje, optionsPorcentaje);
    document.getElementById('variablePorcentaje').value=chartPorcentaje.getImageURI();

    const chartGenero = new google.visualization.PieChart(document.getElementById('graficoGenero'));
    chartGenero.draw(dataGenero, optionsGenero);
    document.getElementById('variableGenero').value=chartGenero.getImageURI();

    const chartPais = new google.visualization.PieChart(document.getElementById('graficoPais'));
    chartPais.draw(dataPais, optionsPais);
    document.getElementById('variablePais').value=chartPais.getImageURI();


}