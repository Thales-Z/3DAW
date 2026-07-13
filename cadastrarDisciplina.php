<?php
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pega os dados do formulário
    $sigla = $_POST["sigla"];
    $nome = $_POST["nome"];
    $carga_horaria = $_POST["carga_horaria"];
    
    // Define o nome do novo arquivo
    $arquivo = "disciplina.txt";

    // Abre o arquivo no modo "a" (append) para adicionar ao final
    $arq = fopen($arquivo, "a") or die("Erro ao abrir arquivo");
    
    // Monta a linha na ordem solicitada: sigla;nome;carga horaria
    $linha = $sigla . ";" . $nome . ";" . $carga_horaria . "\n";
    
    // Grava e fecha o arquivo
    fwrite($arq, $linha);
    fclose($arq);
    
    $msg = "<span style='color: green;'>Disciplina cadastrada com sucesso!</span>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Disciplina</title>
</head>
<body>
    <h1>Cadastrar Nova Disciplina</h1>
    
    <form method="POST" action="">
        Sigla da Disciplina: <input type="text" name="sigla" required placeholder="Ex: MAT"><br><br>
        Nome da Disciplina: <input type="text" name="nome" required placeholder="Ex: Matemática"><br><br>
        Carga Horária (horas): <input type="number" name="carga_horaria" required placeholder="Ex: 60"><br><br>
        <input type="submit" value="Salvar Disciplina">
    </form>
    
    <p><?php echo $msg; ?></p>
    <br>
    <a href="index.php">Voltar para a Tela Inicial</a>
</body>
</html>