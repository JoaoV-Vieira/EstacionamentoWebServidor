document.addEventListener('DOMContentLoaded', () => {
    console.log('Sistema de Estacionamento carregado!');
});

document.addEventListener('DOMContentLoaded', () => {
    const dataHoraInput = document.getElementById('dataHora');
    const duracaoRadios = document.querySelectorAll('input[name="duracao"]');
    const estacionadoAteInput = document.getElementById('estacionadoAte');

    function calcularEstacionadoAte() {
        const dataHoraSelecionada = new Date(dataHoraInput.value);
        if (isNaN(dataHoraSelecionada.getTime())) {
            estacionadoAteInput.value = '';
            return;
        }

        let minutosAdicionais = 0;
        duracaoRadios.forEach(radio => {
            if (radio.checked) {
                switch (radio.value) {
                    case '30min':
                        minutosAdicionais = 30;
                        break;
                    case '1hr':
                        minutosAdicionais = 60;
                        break;
                    case '1h30min':
                        minutosAdicionais = 90;
                        break;
                    case '2hr':
                        minutosAdicionais = 120;
                        break;
                    case '2h30min':
                        minutosAdicionais = 150;
                        break;
                    case '3hr':
                        minutosAdicionais = 180;
                        break;
                }
            }
        });

        if (minutosAdicionais > 0) {
            const dataHoraFinal = new Date(dataHoraSelecionada.getTime() + minutosAdicionais * 60000);
            estacionadoAteInput.value = dataHoraFinal.toLocaleString('pt-BR', {
                dateStyle: 'short',
                timeStyle: 'short'
            });
        } else {
            estacionadoAteInput.value = '';
        }
    }

    dataHoraInput.addEventListener('input', calcularEstacionadoAte);
    duracaoRadios.forEach(radio => radio.addEventListener('change', calcularEstacionadoAte));
});