document.addEventListener("DOMContentLoaded", function() {

    let tiempoRestante = 15;
    const contadorElemento = document.getElementById('contador');

    if (contadorElemento) {

        const intervalo = setInterval(() => {
            if (tiempoRestante > 0) {
                tiempoRestante--;
                contadorElemento.textContent = tiempoRestante;
            } else {
                clearInterval(intervalo);
                window.location.href = '/Monquiz/app/partida/timeOut';
            }
        }, 1000);
    }


    const reportButton = document.querySelector('.floating-button');
    if (reportButton) {
        reportButton.addEventListener('click', function() {
            document.getElementById('reportForm').submit();
        });
    }
});