<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acrónimos</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
 
<h1>Convertir frase a acrónimo</h1>
 
<form method="POST">
    <label for="frase">Ingresa la frase:</label><br>
    <input type="text" id="frase" name="frase"><br><br>
    <button type="submit">Convertir</button>
</form>
 
<?php
class Acronimo {
    private string $frase;
 
    public function __construct(string $frase) {
        $this->frase = $frase;
    }
 
    private function esLetra(string $c): bool {
        $letrasValidas = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZáéíóúÁÉÍÓÚüÜñÑ';
        return strpos($letrasValidas, $c) !== false;
    }
 
    public function convertir(): string {
        $frase = $this->frase;
        $acronimo = '';
        $nuevaLetra = true;
 
        for ($i = 0; $i < strlen($frase); $i++) {
            $c = $frase[$i];
 
            if ($c == ' ' || $c == '-') {
                $nuevaLetra = true;
            } else if ($this->esLetra($c)) {
                if ($nuevaLetra) {
                    $acronimo .= strtoupper($c);
                    $nuevaLetra = false;
                }
            }
        }
 
        return $acronimo;
    }
}
 
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['frase'])) {
    $frase = trim($_POST['frase']);
    $obj = new Acronimo($frase);
    $resultado = $obj->convertir();
 
    echo "<h2>Resultado</h2>";
    echo "<p>Frase: <strong>" . htmlspecialchars($frase) . "</strong></p>";
    echo "<p>Acrónimo: <strong>" . $resultado . "</strong></p>";
}
?>
 
<br>
<a href="./index.php">← Volver al menú</a>
 
</body>
</html>
 