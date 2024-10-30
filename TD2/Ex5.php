<?php

function estPalindrome($chaine) {
    $chaine = strtolower($chaine); 
    $chaine = preg_replace('/[^a-z0-9]/', '', $chaine); 

    $inverse = strrev($chaine); 

    if ($chaine === $inverse) {
        echo "La chaîne \"$chaine\" est un palindrome.";
    } else {
        echo "La chaîne \"$chaine\" n'est pas un palindrome.";
    }
}


estPalindrome("radar");

?>