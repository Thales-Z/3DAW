<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$classe = $_GET['classe'] ?? '';
$acao = $_GET['acao'] ?? '';
$id = $_GET['id'] ?? '';

$dados_recebidos = json_decode(file_get_contents("php://input"), true);

// --- ROTAS DE GESTORES ---
if ($classe === 'usuario') {
    if ($acao === 'cadastrar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $dados_recebidos['nome'] ?? '';
        $email = $dados_recebidos['email'] ?? '';
        if ($nome && $email) {
            $linha = $nome . "|" . $email . PHP_EOL;
            file_put_contents('usuarios.txt', $linha, FILE_APPEND);
            echo json_encode(["status" => "sucesso", "mensagem" => "Gestor cadastrado com sucesso!"]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Dados incompletos."]);
        }
        exit;
    }

    if ($acao === 'listar' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $usuarios = [];
        if (file_exists('usuarios.txt')) {
            $linhas = file('usuarios.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($linhas as $linha) {
                $dados = explode('|', trim($linha));
                if (count($dados) >= 2) {
                    $usuarios[] = ["nome" => $dados[0], "email" => $dados[1]];
                }
            }
        }
        echo json_encode($usuarios);
        exit;
    }
}

// --- ROTAS DE PERGUNTAS ---
if ($classe === 'pergunta') {
    $arquivo = 'perguntas.txt';

    // Listar todas as perguntas
    if ($acao === 'listar' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $perguntas = [];
        if (file_exists($arquivo)) {
            $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($linhas as $linha) {
                $dados = explode('|', trim($linha));
                if (count($dados) >= 4) {
                    $perguntas[] = [
                        "id" => $dados[0],
                        "tipo" => $dados[1],
                        "pergunta" => $dados[2],
                        "opA" => $dados[3] ?? '',
                        "opB" => $dados[4] ?? '',
                        "opC" => $dados[5] ?? '',
                        "opD" => $dados[6] ?? '',
                        "correta" => $dados[7] ?? ''
                    ];
                }
            }
        }
        echo json_encode($perguntas);
        exit;
    }

    // Listar / Ver uma única pergunta
    if ($acao === 'ver' && $_SERVER['REQUEST_METHOD'] === 'GET' && $id) {
        if (file_exists($arquivo)) {
            $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($linhas as $linha) {
                $dados = explode('|', trim($linha));
                if ($dados[0] == $id) {
                    echo json_encode([
                        "id" => $dados[0],
                        "tipo" => $dados[1],
                        "pergunta" => $dados[2],
                        "opA" => $dados[3] ?? '',
                        "opB" => $dados[4] ?? '',
                        "opC" => $dados[5] ?? '',
                        "opD" => $dados[6] ?? '',
                        "correta" => $dados[7] ?? ''
                    ]);
                    exit;
                }
            }
        }
        echo json_encode(["status" => "erro", "mensagem" => "Pergunta não encontrada."]);
        exit;
    }

    // Cadastrar Pergunta (Múltipla Escolha ou Texto)
    if ($acao === 'cadastrar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_novo = time();
        $tipo = $dados_recebidos['tipo'];
        $pergunta = $dados_recebidos['pergunta'];

        if ($tipo === "multipla") {
            $linha = $id_novo . "|" . $tipo . "|" . $pergunta . "|" . $dados_recebidos['opA'] . "|" . $dados_recebidos['opB'] . "|" . $dados_recebidos['opC'] . "|" . $dados_recebidos['opD'] . "|" . $dados_recebidos['correta'] . PHP_EOL;
        } else {
            $linha = $id_novo . "|" . $tipo . "|" . $pergunta . "|" . $dados_recebidos['resposta'] . "||||" . PHP_EOL;
        }

        file_put_contents($arquivo, $linha, FILE_APPEND);
        echo json_encode(["status" => "sucesso", "mensagem" => "Pergunta criada com sucesso!"]);
        exit;
    }

    // Alterar Pergunta
    if ($acao === 'alterar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_alterar = $dados_recebidos['id'];
        $tipo = $dados_recebidos['tipo'];
        $pergunta = $dados_recebidos['pergunta'];

        if ($tipo === "multipla") {
            $nova_linha = $id_alterar . "|" . $tipo . "|" . $pergunta . "|" . $dados_recebidos['opA'] . "|" . $dados_recebidos['opB'] . "|" . $dados_recebidos['opC'] . "|" . $dados_recebidos['opD'] . "|" . $dados_recebidos['correta'] . PHP_EOL;
        } else {
            $nova_linha = $id_alterar . "|" . $tipo . "|" . $pergunta . "|" . $dados_recebidos['resposta'] . "||||" . PHP_EOL;
        }

        if (file_exists($arquivo)) {
            $linhas = file($arquivo);
            $novo_conteudo = "";
            foreach ($linhas as $linha) {
                $dados = explode('|', trim($linha));
                if ($dados[0] == $id_alterar) {
                    $novo_conteudo .= $nova_linha;
                } else {
                    $novo_conteudo .= $linha;
                }
            }
            file_put_contents($arquivo, $novo_conteudo);
            echo json_encode(["status" => "sucesso", "mensagem" => "Pergunta alterada com sucesso!"]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Arquivo não encontrado."]);
        }
        exit;
    }

    // Excluir Pergunta
    if ($acao === 'excluir' && $_SERVER['REQUEST_METHOD'] === 'GET' && $id) {
        if (file_exists($arquivo)) {
            $linhas = file($arquivo);
            $novo_conteudo = "";
            foreach ($linhas as $linha) {
                $dados = explode('|', $linha);
                if (trim($dados[0]) != $id) {
                    $novo_conteudo .= $linha;
                }
            }
            file_put_contents($arquivo, $novo_conteudo);
            echo json_encode(["status" => "sucesso", "mensagem" => "Pergunta excluída com sucesso!"]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Arquivo não encontrado."]);
        }
        exit;
    }
}

echo json_encode(["status" => "erro", "mensagem" => "Rota inválida."]);
?>