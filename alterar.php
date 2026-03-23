<?php
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $busca = $_POST["matricula_busca"];
    $novo_nome = $_POST["novo_nome"];
    $novo_email = $_POST["novo_email"];
    $arquivo = "alunos.txt";

    if (file_exists($arquivo)) {
        $linhas = file($arquivo);
        $novo_conteudo = "";
        $encontrado = false;

        foreach ($linhas as $linha) {
            $linha_limpa = trim($linha);
            if (empty($linha_limpa)) continue;

            $dados = explode(";", $linha_limpa);

            // Se achou a matrícula, troca os dados
            if ($dados[0] == $busca) {
                $novo_conteudo .= $busca . ";" . $novo_nome . ";" . $novo_email . "\n";
                $encontrado = true;
            } else {
                // Se não é a matrícula, mantém a linha antiga
                $novo_conteudo .= $linha_limpa . "\n";
            }
        }

        if ($encontrado) {
            file_put_contents($arquivo, $novo_conteudo);
            $msg = "<span style='color: green;'>Dados alterados com sucesso!</span>";
        } else {
            $msg = "<span style='color: red;'>Matrícula não encontrada!</span>";
        }
    } else {
        $msg = "O arquivo de alunos não existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar Aluno</title>
</head>
<body>
    <h1>Alterar Dados do Aluno</h1>
    
    <form method="POST" action="">
        Matrícula (Busca): <input type="text" name="matricula_busca" required><br><br>
        Novo Nome: <input type="text" name="novo_nome" required><br><br>
        Novo E-mail: <input type="email" name="novo_email" required><br><br>
        <input type="submit" value="Atualizar Dados">
    </form>
    
    <p><?php echo $msg; ?></p>
    <br>
    <a href="index.php">Voltar para a Tela Inicial</a>
</body>
</html>
