<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Conjuntos</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>

<h1>Operaciones de Conjuntos</h1>

<form method="POST">
    <label>Conjunto A (separados por comas):</label>
    <input type="text" name="conjuntoA" placeholder="Ej: 1, 2, 3, 4"> 

    <label>Conjunto B (separados por comas):</label>
    <input type="text" name="conjuntoB" placeholder="Ej: 3, 4, 5, 6"> 

    <button type="submit">Calcular</button>
</form>

<?php
class Conjunto {
    private array $elementos;

    public function __construct(string $entrada) {
        $partes = explode(',', $entrada);
        $arr = [];
        for ($i = 0; $i < count($partes); $i++) {
            $num = (int) trim($partes[$i]);
            if (!in_array($num, $arr)) {
                $arr[] = $num;
            }
        }
        $this->elementos = $arr;
    }

    public function obtener(): array {
        return $this->elementos;
    }

    public function union(Conjunto $otro): array {
        $resultado = $this->elementos;
        $b = $otro->obtener();

        for ($i = 0; $i < count($b); $i++) {
            if (!in_array($b[$i], $resultado)) {
                $resultado[] = $b[$i];
            }
        }

        sort($resultado);
        return $resultado;
    }

    public function interseccion(Conjunto $otro): array {
        $resultado = [];
        $b = $otro->obtener();

        for ($i = 0; $i < count($this->elementos); $i++) {
            if (in_array($this->elementos[$i], $b)) {
                $resultado[] = $this->elementos[$i];
            }
        }

        sort($resultado);
        return $resultado;
    }

    public function diferencia(Conjunto $otro): array {
        $resultado = [];
        $b = $otro->obtener();

        for ($i = 0; $i < count($this->elementos); $i++) {
            if (!in_array($this->elementos[$i], $b)) {
                $resultado[] = $this->elementos[$i];
            }
        }

        sort($resultado);
        return $resultado;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['conjuntoA']) && !empty($_POST['conjuntoB'])) {
    $a = new Conjunto($_POST['conjuntoA']);
    $b = new Conjunto($_POST['conjuntoB']);

    $union        = $a->union($b);
    $interseccion = $a->interseccion($b);
    $diferenciaAB = $a->diferencia($b);
    $diferenciaBA = $b->diferencia($a);

    echo '<h2>Resultados</h2>';
    echo '<p>Conjunto A: <strong>{' . implode(', ', $a->obtener()) . '}</strong></p>';
    echo '<p>Conjunto B: <strong>{' . implode(', ', $b->obtener()) . '}</strong></p>';
    echo '<p>Unión (A ∪ B): <strong>{' . implode(', ', $union) . '}</strong></p>';
    echo '<p>Intersección (A ∩ B): <strong>{' . implode(', ', $interseccion) . '}</strong></p>';
    echo '<p>Diferencia (A - B): <strong>{' . implode(', ', $diferenciaAB) . '}</strong></p>';
    echo '<p>Diferencia (B - A): <strong>{' . implode(', ', $diferenciaBA) . '}</strong></p>';
}
?>

 
<a class="volver" href="./index.php">← Volver al menú</a>
 

</body>
</html>