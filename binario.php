<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Conversión a Binario</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
 
<h1>Convertir número entero a binario</h1>
 
<form method="POST">
    <label for="numero">Ingresa un número entero:</label><br>
    <input type="number" id="numero" name="numero" min="0"><br><br>
    <button type="submit">Convertir</button>
</form>
 
<?php
class Binario {
    private int $numero;
 
    public function __construct(int $numero) {
        $this->numero = $numero;
    }
 
    public function convertir(): string {
        if ($this->numero === 0) {
            return '0';
        }
 
        $numero = $this->numero;
        $residuos = [];
 
        while ($numero > 0) {
            $residuos[] = $numero % 2;
            $numero = (int)($numero / 2);
        }
 
        $binario = '';
        for ($i = count($residuos) - 1; $i >= 0; $i--) {
            $binario .= $residuos[$i];
        }
 
        return $binario;
    }
}
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numero']) && $_POST['numero'] !== '') {
    $numero = (int) $_POST['numero'];
    $obj = new Binario($numero);
    $resultado = $obj->convertir();
 
    echo '<h2>Resultado</h2>';
    echo '<p>Número ingresado: <strong>' . $numero . '</strong></p>';
    echo '<p>En binario: <strong>' . $resultado . '</strong></p>';
}
?>
 
<br>
<a href="./index.php">← Volver al menú</a>
 
</body>
</html>