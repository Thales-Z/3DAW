<?php
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST["matricula"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $arquivo = "alunos.txt";

    $arq = fopen($arquivo, "a") or die("Erro ao abrir arquivo");
    $linha = $matricula . ";" . $nome . ";" . $email . "\n";
    fwrite($arq, $linha);
    fclose($arq);
    
    $msg = "<span style='color: green;'>Aluno cadastrado com sucesso!</span>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Aluno</title>
</head>
<body>
    <h1>Cadastrar Novo Aluno</h1>
    
    <form method="POST" action="">
        Matrícula: <input type="text" name="matricula" required><br><br>
        Nome: <input type="text" name="nome" required><br><br>
        E-mail: <input type="email" name="email" required><br><br>
        <input type="submit" value="Salvar Aluno">
    </form>
    
    <p><?php echo $msg; ?></p>
    <br>
    <a href="index.php">Voltar para a Tela Inicial</a>
</body>
</html>
