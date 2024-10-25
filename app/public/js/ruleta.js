function wheelOfFortune(selector) {
    const node = document.querySelector(selector);
    if (!node) return;

    const spin = node.querySelector('button');
    const wheel = node.querySelector('ul');
    const items = ['3', '2', '1', '8', '7', '6', '5', '4']; // Las 8 casillas
    let animation;
    let previousEndDegree = 0;

    spin.addEventListener('click', () => {

        spin.disabled = true;


        const randomAdditionalDegrees = Math.random() * 360 + 1800;
        const newEndDegree = previousEndDegree + randomAdditionalDegrees;

        animation = wheel.animate([
            { transform: `rotate(${previousEndDegree}deg)` },
            { transform: `rotate(${newEndDegree}deg)` }
        ], {
            duration: 4000,
            direction: 'normal',
            easing: 'cubic-bezier(0.440, -0.205, 0.000, 1.130)',
            fill: 'forwards',
            iterations: 1
        });

        previousEndDegree = newEndDegree;


        animation.onfinish = () => {
            const adjustedDegrees = (newEndDegree % 360) + (360 / items.length) / 2;
            const selectedIndex = Math.floor((adjustedDegrees / 360) * items.length) % items.length;
            const selectedValue = items[selectedIndex];

            console.log(newEndDegree);
            console.log('Casilla seleccionada:', selectedValue);


            fetch('/Monquiz/app/partida/resultado', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    valor: selectedValue
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        setTimeout(function (){
                            window.location.href = '/Monquiz/app/partida/mostrarPregunta';
                        }, 500);

                    } else {
                        console.error('Error:', data.mensaje);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    spin.disabled = false;
                });
        };
    });
}

// Uso
wheelOfFortune('.ui-wheel-of-fortune');