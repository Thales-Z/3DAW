<?php
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $busca = $_POST["matricula_busca"];
    $arquivo = "alunos.txt";

    if (file_exists($arquivo)) {
        $linhas = file($arquivo);
        $novo_conteudo = "";
        $encontrado = false;

        foreach ($linhas as $linha) {
            $linha_limpa = trim($linha);
            if (empty($linha_limpa)) continue;

            $dados = explode(";", $linha_limpa);

            // Se for igual à matrícula buscada, NÃO adiciona ao novo conteúdo (exclui)
            if ($dados[0] == $busca) {
                $encontrado = true;
            } else {
                $novo_conteudo .= $linha_limpa . "\n";
            }
        }

        if ($encontrado) {
            file_put_contents($arquivo, $novo_conteudo);
            $msg = "<span style='color: green;'>Aluno excluído com sucesso!</span>";
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
    <title>Excluir Aluno</title>
</head>
<body>
    <h1>Excluir Aluno</h1>
    
    <form method="POST" action="">
        Matrícula do Aluno: <input type="text" name="matricula_busca" required><br><br>
        <input type="submit" value="Excluir Aluno">
    </form>
    
    <p><?php echo $msg; ?></p>
    <br>
    <a href="index.php">Voltar para a Tela Inicial</a>
</body>
</html>
