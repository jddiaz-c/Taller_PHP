<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadística</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
 
<h1>Promedio, Mediana y Moda</h1>
 
<?php
class Estadistica {
    private array $numeros; 
    public function __construct(array $numeros) {
        $this->numeros = $numeros;
    }
    public function promedio(): float {
        $suma = 0;
        for ($i = 0; $i < count($this->numeros); $i++) {
            $suma = $suma + $this->numeros[$i];
        }
        return $suma / count($this->numeros);
    }
    public function mediana(): float {
        $arr = $this->numeros;
        sort($arr);
        $cantidad = count($arr);
        $mitad = (int)($cantidad / 2);
 
        if ($cantidad % 2 === 0) {
            return ($arr[$mitad - 1] + $arr[$mitad]) / 2;
        } else {
            return $arr[$mitad];
        }
    }
    public function moda(): array {
        $frecuencias = [];
        for ($i = 0; $i < count($this->numeros); $i++) {
            $num = $this->numeros[$i];
            if (isset($frecuencias[$num])) {
                $frecuencias[$num] = $frecuencias[$num] + 1;
            } else {
                $frecuencias[$num] = 1;
            }
        }
 
        $maxFrecuencia = 0;
        for ($i = 0; $i < count($this->numeros); $i++) {
            $num = $this->numeros[$i];
            if ($frecuencias[$num] > $maxFrecuencia) {
                $maxFrecuencia = $frecuencias[$num];
            }
        }
 
        $moda = [];
        foreach ($frecuencias as $num => $freq) {
            if ($freq === $maxFrecuencia) {
                $moda[] = $num;
            }
        }
 
        return $moda;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' || !isset($_POST['paso'])) {
    echo '
    <form method="POST">
        <input type="hidden" name="paso" value="1">
        <label>¿Cuántos números vas a ingresar?</label>
        <input type="number" name="cantidad" min="1"> 
        <button type="submit">Continuar</button>
    </form>';
} else if ($_POST['paso'] === '1') {
    $cantidad = (int) $_POST['cantidad'];
    echo '<form method="POST">';
    echo '<input type="hidden" name="paso" value="2">';
    echo '<input type="hidden" name="cantidad" value="' . $cantidad . '">';

    for ($i = 1; $i <= $cantidad; $i++) {
        echo '<label>Número ' . $i . ':</label>';
        echo '<input type="number" step="any" name="numeros[]"> ';
    }
 
    echo '<button type="submit">Calcular</button>';
    echo '</form>';
 
} else if ($_POST['paso'] === '2') {
    $numeros = $_POST['numeros'];
    $numerosFloat = [];
    for ($i = 0; $i < count($numeros); $i++) {
        $numerosFloat[] = (float) $numeros[$i];
    }
 
    $obj = new Estadistica($numerosFloat);
 
    $moda = $obj->moda();
    $modaTexto = implode(', ', $moda);
 
    echo '<h2>Resultados</h2>';
    echo '<p>Números: <strong>' . implode(', ', $numerosFloat) . '</strong></p>';
    echo '<p>Promedio: <strong>' . $obj->promedio() . '</strong></p>';
    echo '<p>Mediana: <strong>' . $obj->mediana() . '</strong></p>';
    echo '<p>Moda: <strong>' . $modaTexto . '</strong></p>';
 
    echo ' <form method="POST">
        <input type="hidden" name="paso" value="1">
        <input type="hidden" name="cantidad" value="' . $_POST['cantidad'] . '">
        <a href="estadistica.php">← Volver a ingresar números</a>
    </form>';
}
?>
 
 
<a class="volver" href="./index.php">← Volver al menú</a>
 
 
</body>
</html>
 