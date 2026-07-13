document.addEventListener("DOMContentLoaded", () => {
    carregarUsuarios();
    carregarPerguntas();
});

function carregarUsuarios() {
    fetch('api.php?classe=usuario&acao=listar')
        .then(response => response.json())
        .then(usuarios => {
            const lista = document.getElementById('listaUsuarios');
            lista.innerHTML = "";
            if(usuarios.length === 0) {
                lista.innerHTML = "<li>Nenhum gestor cadastrado ainda.</li>";
                return;
            }
            usuarios.forEach(user => {
                lista.innerHTML += `<li><b>${user.nome}</b> - ${user.email}</li>`;
            });
        });
}

function carregarPerguntas() {
    fetch('api.php?classe=pergunta&acao=listar')
        .then(response => response.json())
        .then(perguntas => {
            const tbody = document.getElementById('tabelaPerguntas');
            tbody.innerHTML = "";
            if(perguntas.length === 0) {
                tbody.innerHTML = "<tr><td colspan='4'>Nenhuma pergunta cadastrada.</td></tr>";
                return;
            }
            perguntas.forEach(p => {
                tbody.innerHTML += `
                    <tr>
                        <td>${p.id}</td>
                        <td>${p.tipo.toUpperCase()}</td>
                        <td>${p.pergunta}</td>
                        <td>
                            <a href="ver_pergunta.html?id=${p.id}">Ver</a> | 
                            <a href="alterar_pergunta.html?id=${p.id}">Alterar</a> | 
                            <button onclick="excluirPergunta(${p.id})">Excluir</button>
                        </td>
                    </tr>
                `;
            });
        });
}

function excluirPergunta(id) {
    if(confirm("Tem certeza que deseja excluir esta pergunta?")) {
        fetch(`api.php?classe=pergunta&acao=excluir&id=${id}`)
            .then(response => response.json())
            .then(res => {
                alert(res.mensagem);
                carregarPerguntas();
            });
    }
}