document.addEventListener('DOMContentLoaded', () => {
    console.log('Sistema de Estacionamento carregado!');
});

document.addEventListener('DOMContentLoaded', () => {
    const dataHoraInput = document.getElementById('dataHora');
    const duracaoRadios = document.querySelectorAll('input[name="duracao"]');
    const estacionadoAteSpan = document.getElementById('estacionadoAte');

    function calcularEstacionadoAte() {
        const dataHoraSelecionada = new Date(dataHoraInput.value);
        if (isNaN(dataHoraSelecionada.getTime())) {
            estacionadoAteSpan.textContent = 'Será calculado automaticamente';
            return;
        }

        let minutosAdicionais = 0;
        duracaoRadios.forEach(radio => {
            if (radio.checked) {
                switch (radio.value) {
                    case '30min': minutosAdicionais = 30; break;
                    case '1hr': minutosAdicionais = 60; break;
                    case '1h30min': minutosAdicionais = 90; break;
                    case '2hr': minutosAdicionais = 120; break;
                    case '2h30min': minutosAdicionais = 150; break;
                    case '3hr': minutosAdicionais = 180; break;
                }
            }
        });

        if (minutosAdicionais > 0) {
            const dataHoraFinal = new Date(dataHoraSelecionada.getTime() + minutosAdicionais * 60000);
            const dia = String(dataHoraFinal.getDate()).padStart(2, '0');
            const mes = String(dataHoraFinal.getMonth() + 1).padStart(2, '0');
            const ano = dataHoraFinal.getFullYear();
            const hora = String(dataHoraFinal.getHours()).padStart(2, '0');
            const min = String(dataHoraFinal.getMinutes()).padStart(2, '0');
            estacionadoAteSpan.textContent = `${dia}/${mes}/${ano} ${hora}:${min}`;
        } else {
            estacionadoAteSpan.textContent = 'Será calculado automaticamente';
        }
    }

    if (dataHoraInput) dataHoraInput.addEventListener('input', calcularEstacionadoAte);
    duracaoRadios.forEach(radio => radio.addEventListener('change', calcularEstacionadoAte));
});