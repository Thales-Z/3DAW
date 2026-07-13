document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    if (id) {
        fetch(`api.php?classe=pergunta&acao=ver&id=${id}`)
            .then(response => response.json())
            .then(p => {
                const container = document.getElementById('conteudoPergunta');
                
                let html = `<b>ID:</b> ${p.id}<br><br>`;
                html += `<b>Pergunta:</b> ${p.pergunta}<br><br>`;

                if (p.tipo === "multipla") {
                    html += `<b>Opção A:</b> ${p.opA}<br>`;
                    html += `<b>Opção B:</b> ${p.opB}<br>`;
                    html += `<b>Opção C:</b> ${p.opC}<br>`;
                    html += `<b>Opção D:</b> ${p.opD}<br><br>`;
                    html += `<b>Resposta Correta:</b> Letra ${p.correta}<br>`;
                } else {
                    html += `<b>Resposta Esperada:</b> ${p.opA}<br>`;
                }

                container.innerHTML = html;
            });
    }
});