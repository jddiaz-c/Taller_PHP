<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Fibonacci / Factorial</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
 
<h1>Fibonacci / Factorial</h1>
 
<form method="POST">
    <label for="numero">Ingresa un número:</label><br>
    <input type="number" id="numero" name="numero" min="1"><br><br>
 
    <label>Selecciona la operación:</label><br>
    <input type="radio" id="fibonacci" name="operacion" value="fibonacci">
    <label for="fibonacci">Fibonacci</label><br>
    <input type="radio" id="factorial" name="operacion" value="factorial">
    <label for="factorial">Factorial</label><br><br>
 
    <button type="submit">Calcular</button>
</form>
 
<?php
class Fibonacci {
    private int $numero;
 
    public function __construct(int $numero) {
        $this->numero = $numero;
    }
 
    public function serie(): array {
        $serie = [];
        $a = 0;
        $b = 1;
 
        for ($i = 0; $i < $this->numero; $i++) {
            $serie[] = $a;
            $temp = $a + $b;
            $a = $b;
            $b = $temp;
        }
 
        return $serie;
    }
}
 
class Factorial {
    private int $numero;
 
    public function __construct(int $numero) {
        $this->numero = $numero;
    }
 
    public function calcular(): int {
        $resultado = 1;
 
        for ($i = 1; $i <= $this->numero; $i++) {
            $resultado = $resultado * $i;
        }
 
        return $resultado;
    }
}
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['numero']) && !empty($_POST['operacion'])) {
    $numero = (int) $_POST['numero'];
    $operacion = $_POST['operacion'];
 
    echo "<h2>Resultado</h2>";
    echo "<p>Número ingresado: <strong>" . $numero . "</strong></p>";
 
    if ($operacion === 'fibonacci') {
        $obj = new Fibonacci($numero);
        $serie = $obj->serie();
        echo "<p>Serie Fibonacci: <strong>" . implode(', ', $serie) . "</strong></p>";
 
    } else if ($operacion === 'factorial') {
        $obj = new Factorial($numero);
        $resultado = $obj->calcular();
        echo "<p>Factorial de " . $numero . ": <strong>" . $resultado . "</strong></p>";
    }
}
?>
 
<br>
<a href="./index.php">← Volver al menú</a>
 
</body>
</html>