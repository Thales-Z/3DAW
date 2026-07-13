document.addEventListener("DOMContentLoaded", () => {
    // Pega o ID passado via parâmetro na URL (?id=123456)
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    if (id) {
        fetch(`api.php?classe=pergunta&acao=ver&id=${id}`)
            .then(response => response.json())
            .then(p => {
                document.getElementById('perguntaId').value = p.id;
                document.getElementById('perguntaTipo').value = p.tipo;
                document.getElementById('pergunta').value = p.pergunta;

                if (p.tipo === "multipla") {
                    document.getElementById('blocoMultipla').style.display = 'block';
                    document.getElementById('opA').value = p.opA;
                    document.getElementById('opB').value = p.opB;
                    document.getElementById('opC').value = p.opC;
                    document.getElementById('opD').value = p.opD;
                    document.getElementById(`correta${p.correta}`).checked = true;
                } else {
                    document.getElementById('blocoTexto').style.display = 'block';
                    document.getElementById('resposta').value = p.opA; // No txt a resposta fica no índice 3 (opA)
                }
            });
    }
});

document.getElementById('formAlterar').addEventListener('submit', function(e) {
    e.preventDefault();

    const tipo = document.getElementById('perguntaTipo').value;
    const dados = {
        id: document.getElementById('perguntaId').value,
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

    fetch('api.php?classe=pergunta&acao=alterar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dados)
    })
    .then(response => response.json())
    .then(res => {
        alert(res.mensagem);
        window.location.href = "index.html";
    });
});