document.getElementById('formUsuario').addEventListener('submit', function(e) {
    e.preventDefault();

    const dados = {
        nome: document.getElementById('nome').value,
        email: document.getElementById('email').value
    };

    fetch('api.php?classe=usuario&acao=cadastrar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dados)
    })
    .then(response => response.json())
    .then(res => {
        alert(res.mensagem);
        if(res.status === "sucesso") {
            window.location.href = "cadastrar_pergunta.html";
        }
    });
});