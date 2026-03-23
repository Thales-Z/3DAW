<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema Escolar - Início</title>
</head>
<body>
    <h1>Gestão de Alunos</h1>
    
    <a href="cadastrarAluno.php"><button>Cadastrar Novo Aluno</button></a>
    <a href="alterar.php"><button>Alterar Aluno</button></a>
    <a href="excluir.php"><button>Excluir Aluno</button></a>
    <br><br>

    <h3>Lista de Alunos Cadastrados:</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>Matrícula</th>
            <th>Nome</th>
            <th>E-mail</th>
        </tr>
        <?php
        $arquivo = "alunos.txt";
        if (file_exists($arquivo)) {
            $linhas = file($arquivo);
            foreach ($linhas as $linha) {
                $linha_limpa = trim($linha);
                if (empty($linha_limpa)) continue;

                $dados = explode(";", $linha_limpa);
                echo "<tr><td>{$dados[0]}</td><td>{$dados[1]}</td><td>{$dados[2]}</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhum aluno cadastrado ainda.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
