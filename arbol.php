<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Árbol Binario</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>

<h1>Construcción de Árbol Binario</h1>

<form method="POST">
    <p>Ingresa mínimo dos de los tres recorridos (separados por comas):</p>

    <label>Preorden:</label>
    <input type="text" name="preorden" placeholder="Ej: A, B, D, E, C">

    <label>Inorden:</label>
    <input type="text" name="inorden" placeholder="Ej: D, B, E, A, C">

    <label>Postorden:</label>
    <input type="text" name="postorden" placeholder="Ej: D, E, B, C, A">

    <button type="submit">Construir árbol</button>
</form>

<?php
class NodoArbol {
    public string $valor;
    public ?NodoArbol $izquierda;
    public ?NodoArbol $derecha;

    public function __construct(string $valor) {
        $this->valor     = $valor;
        $this->izquierda = null;
        $this->derecha   = null;
    }
}

class ArbolBinario {
    public ?NodoArbol $raiz;

    public function __construct() {
        $this->raiz = null;
    }

    public function desdePreordenInorden(array $pre, array $ino): ?NodoArbol {
        if (count($pre) === 0 || count($ino) === 0) {
            return null;
        }

        $raizValor = $pre[0];
        $nodo = new NodoArbol($raizValor);

        $indice = 0;
        for ($i = 0; $i < count($ino); $i++) {
            if ($ino[$i] === $raizValor) {
                $indice = $i;
                break;
            }
        }

        $inoIzq = array_slice($ino, 0, $indice);
        $inoDer  = array_slice($ino, $indice + 1);
        $preIzq  = array_slice($pre, 1, count($inoIzq));
        $preDer  = array_slice($pre, 1 + count($inoIzq));

        $nodo->izquierda = $this->desdePreordenInorden($preIzq, $inoIzq);
        $nodo->derecha   = $this->desdePreordenInorden($preDer, $inoDer);

        return $nodo;
    }
    public function desdeInordenPostorden(array $ino, array $post): ?NodoArbol {
        if (count($ino) === 0 || count($post) === 0) {
            return null;
        }

        $raizValor = $post[count($post) - 1];
        $nodo = new NodoArbol($raizValor);

        $indice = 0;
        for ($i = 0; $i < count($ino); $i++) {
            if ($ino[$i] === $raizValor) {
                $indice = $i;
                break;
            }
        }

        $inoIzq  = array_slice($ino, 0, $indice);
        $inoDer  = array_slice($ino, $indice + 1);
        $postIzq = array_slice($post, 0, count($inoIzq));
        $postDer = array_slice($post, count($inoIzq), count($inoDer));

        $nodo->izquierda = $this->desdeInordenPostorden($inoIzq, $postIzq);
        $nodo->derecha   = $this->desdeInordenPostorden($inoDer, $postDer);

        return $nodo;
    }

    public function desdePreordenPostorden(array $pre, array $post): ?NodoArbol {
        if (count($pre) === 0) {
            return null;
        }

        $nodo = new NodoArbol($pre[0]);

        if (count($pre) === 1) {
            return $nodo;
        }

        $raizIzq = $pre[1];
        $indice = 0;
        for ($i = 0; $i < count($post); $i++) {
            if ($post[$i] === $raizIzq) {
                $indice = $i;
                break;
            }
        }

        $postIzq = array_slice($post, 0, $indice + 1);
        $postDer = array_slice($post, $indice + 1, count($post) - $indice - 2);
        $preIzq  = array_slice($pre, 1, count($postIzq));
        $preDer  = array_slice($pre, 1 + count($postIzq));

        $nodo->izquierda = $this->desdePreordenPostorden($preIzq, $postIzq);
        $nodo->derecha   = $this->desdePreordenPostorden($preDer, $postDer);

        return $nodo;
    }
   public function imprimir(?NodoArbol $nodo, string $prefijo = '', bool $esIzquierda = true, bool $esRaiz = true): void {
    if ($nodo === null) {
        return;
    }

    if ($esRaiz) {
        echo $nodo->valor . "\n";
    } else {
        echo $prefijo . ($esIzquierda ? '├── ' : '└── ') . $nodo->valor . "\n";
    }

    $nuevoPrefijo = $esRaiz ? '' : $prefijo . ($esIzquierda ? '│   ' : '    ');

    if ($nodo->izquierda !== null) {
        $this->imprimir($nodo->izquierda, $nuevoPrefijo, true, false);
    }
    if ($nodo->derecha !== null) {
        $this->imprimir($nodo->derecha, $nuevoPrefijo, false, false);
    }
}
}

function parsear(string $entrada): array {
    $partes = explode(',', $entrada);
    $arr = [];
    for ($i = 0; $i < count($partes); $i++) {
        $val = trim($partes[$i]);
        if ($val !== '') {
            $arr[] = $val;
        }
    }
    return $arr;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preorden  = !empty($_POST['preorden'])  ? parsear($_POST['preorden'])  : [];
    $inorden   = !empty($_POST['inorden'])   ? parsear($_POST['inorden'])   : [];
    $postorden = !empty($_POST['postorden']) ? parsear($_POST['postorden']) : [];

    $tienesPre  = count($preorden)  > 0;
    $tieneIno   = count($inorden)   > 0;
    $tienePost  = count($postorden) > 0;

    $cantidad = ($tienesPre ? 1 : 0) + ($tieneIno ? 1 : 0) + ($tienePost ? 1 : 0);

    if ($cantidad < 2) {
        echo '<p>Por favor ingresa mínimo dos recorridos.</p>';
    } else {
        $arbol = new ArbolBinario();

        if ($tienesPre && $tieneIno) {
            $arbol->raiz = $arbol->desdePreordenInorden($preorden, $inorden);
        } else if ($tieneIno && $tienePost) {
            $arbol->raiz = $arbol->desdeInordenPostorden($inorden, $postorden);
        } else if ($tienesPre && $tienePost) {
            $arbol->raiz = $arbol->desdePreordenPostorden($preorden, $postorden);
        }

        echo '<h2>Árbol construido</h2>';
        echo '<pre style="font-size: 1.1rem;">';
        $arbol->imprimir($arbol->raiz);
        echo '</pre>';
    }
}
?>

 
<a class="volver" href="./index.php">← Volver al menú</a>
 

</body>
</html>