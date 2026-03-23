<?php
// Inicializa as variáveis para evitar avisos (warnings) na tela
$resultado = "";
$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pega os valores do formulário
    $a = $_POST["a"];
    $b = $_POST["b"];
    $operador = $_POST["operador"];

    // Estrutura switch para lidar com as diferentes operações
    switch ($operador) {
        case "soma":
            $resultado = $a + $b;
            break;
        case "sub":
            $resultado = $a - $b;
            break;
        case "multi":
            $resultado = $a * $b;
            break;
        case "divide":
            // Evita o erro de divisão por zero
            if ($b == 0) {
                $erro = "Erro: Não é possível dividir por zero!";
            } else {
                $resultado = $a / $b;
            }
            break;
        case "potencia":
            // Eleva 'a' à potência de 'b'
            $resultado = pow($a, $b); 
            break;
        case "resto":
            // Pega o resto da divisão de 'a' por 'b'
            if ($b == 0) {
                $erro = "Erro: Não é possível dividir por zero!";
            } else {
                $resultado = $a % $b;
            }
            break;
        default:
            $erro = "Operador não definido ou inválido.";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Calculadora PHP</title>
</head>
<body>
    <h1><?php echo 'Minha Calculadora Expandida!'; ?></h1>

    <form method="POST" action="">
        <label for="a">Valor A:</label>
        <input type="number" step="any" name="a" id="a" required><br><br>
        
        <label for="b">Valor B:</label>
        <input type="number" step="any" name="b" id="b" required><br><br>
        
        <strong>Operação:</strong><br>
        <input type="radio" name="operador" value="soma" required> Soma (+)<br>
        <input type="radio" name="operador" value="sub"> Subtração (-)<br>
        <input type="radio" name="operador" value="multi"> Multiplicação (*)<br>
        <input type="radio" name="operador" value="divide"> Divisão (/)<br>
        <input type="radio" name="operador" value="potencia"> Potência (a^b)<br>
        <input type="radio" name="operador" value="resto"> Resto da divisão (%)<br><br>
        
        <input type="submit" value="Calcular">
    </form>

    <br>
    
    <?php
    // Exibe o resultado ou a mensagem de erro, se o formulário tiver sido enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($erro != "") {
            echo "<h3 style='color: red;'>" . $erro . "</h3>";
        } else {
            echo "<h3 style='color: green;'>Resultado: " . $resultado . "</h3>";
        }
    }
    ?>
    
</body>
</html>
