const selectTipo = document.getElementById('tipoPergunta');
const blocoMultipla = document.getElementById('blocoMultipla');
const blocoTexto = document.getElementById('blocoTexto');

// Altera a exibição dos campos de acordo com o tipo selecionado
selectTipo.addEventListener('change', () => {
    if (selectTipo.value === 'multipla') {
        blocoMultipla.style.display = 'block';
        blocoTexto.style.display = 'none';
    } else {
        blocoMultipla.style.display = 'none';
        blocoTexto.style.display = 'block';
    }
});

document.getElementById('formPergunta').addEventListener('submit', function(e) {
    e.preventDefault();

    const tipo = selectTipo.value;
    const dados = {
        tipo: tipo,
        pergunta: document.getElementById('pergunta').value
    };

    if (tipo === 'multipla') {
        dados.opA = document.getElementById('opA').value;
        dados.opB = document.getElementById('opB').value;
        dados.opC = document.getElementById('opC').value;
        dados.opD = document.getElementById('opD').value;
        dados.correta = document.querySelector('input[name="correta"]:checked').value;
    } else {
        dados.resposta = document.getElementById('resposta').value;
    }

    fetch('api.php?classe=pergunta&acao=cadastrar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dados)
    })
    .then(response => response.json())
    .then(res => {
        alert(res.mensagem);
        document.getElementById('formPergunta').reset();
    });
});