<?php
function inverserChaine($chaine) {
    $chaineInverse = "";
    for ($i = strlen($chaine) - 1; $i >= 0; $i--) {
        $chaineInverse .= $chaine[$i];
    }
    return $chaineInverse;
}

$chaine = "Hello";
$chaineInversee = inverserChaine($chaine);
echo $chaineInversee; 

?>