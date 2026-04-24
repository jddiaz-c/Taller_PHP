<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora</title>
    <link rel="stylesheet" href="./css/styles.css">
<body>

<h1>Calculadora</h1>

<form method="POST">
    <input type="hidden" name="accion" value="calcular">

    <label>Número 1:</label> 
    <input type="number" step="any" name="num1">  

    <label>Operación:</label> 
    <select name="operacion">
        <option value="suma">Suma (+)</option>
        <option value="resta">Resta (-)</option>
        <option value="multiplicacion">Multiplicación (×)</option>
        <option value="division">División (÷)</option>
        <option value="modulo">Módulo (%)</option>
    </select>  

    <label>Número 2:</label> 
    <input type="number" step="any" name="num2">  

    <button type="submit">Calcular</button>
</form>

<?php
class Calculadora {
    private float $num1;
    private float $num2;
    private string $operacion;

    public function __construct(float $num1, float $num2, string $operacion) {
        $this->num1      = $num1;
        $this->num2      = $num2;
        $this->operacion = $operacion;
    }

    public function calcular(): string {
        if ($this->operacion === 'suma') {
            return (string)($this->num1 + $this->num2);
        } else if ($this->operacion === 'resta') {
            return (string)($this->num1 - $this->num2);
        } else if ($this->operacion === 'multiplicacion') {
            return (string)($this->num1 * $this->num2);
        } else if ($this->operacion === 'division') {
            if ($this->num2 == 0) {
                return 'Error: no se puede dividir entre cero';
            }
            return (string)($this->num1 / $this->num2);
        } else if ($this->operacion === 'modulo') {
            if ($this->num2 == 0) {
                return 'Error: no se puede dividir entre cero';
            }
            return (string)((int)$this->num1 % (int)$this->num2);
        }
        return 'Operación no válida';
    }

    public function obtenerSimbolo(): string {
        if ($this->operacion === 'suma')           return '+';
        if ($this->operacion === 'resta')          return '-';
        if ($this->operacion === 'multiplicacion') return '×';
        if ($this->operacion === 'division')       return '÷';
        if ($this->operacion === 'modulo')         return '%';
        return '?';
    }
}

session_start();

if (!isset($_SESSION['historial'])) {
    $_SESSION['historial'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['accion'] === 'calcular' && isset($_POST['num1'], $_POST['num2'], $_POST['operacion'])) {
        $num1      = (float) $_POST['num1'];
        $num2      = (float) $_POST['num2'];
        $operacion = $_POST['operacion'];

        $calc      = new Calculadora($num1, $num2, $operacion);
        $resultado = $calc->calcular();
        $simbolo   = $calc->obtenerSimbolo();

        echo '<h2>Resultado</h2>';
        echo '<p>' . $num1 . ' ' . $simbolo . ' ' . $num2 . ' = <strong>' . $resultado . '</strong></p>';

        if (!str_starts_with($resultado, 'Error')) {
            $_SESSION['historial'][] = $num1 . ' ' . $simbolo . ' ' . $num2 . ' = ' . $resultado;
        }

    } else if ($_POST['accion'] === 'borrar') {
        $_SESSION['historial'] = [];
    }
}

echo '<h2>Historial</h2>';

if (count($_SESSION['historial']) === 0) {
    echo '<p>No hay operaciones en el historial.</p>';
} else {
    echo '<ul>';
    for ($i = 0; $i < count($_SESSION['historial']); $i++) {
        echo '<li>' . $_SESSION['historial'][$i] . '</li>';
    }
    echo '</ul>';

    echo '<form method="POST">
        <input type="hidden" name="accion" value="borrar">
        <button type="submit">Borrar historial</button>
    </form>';
}
?>

 
<a class="volver" href="./index.php">← Volver al menú</a>
 

</body>
</html>