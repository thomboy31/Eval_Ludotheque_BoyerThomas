<?php

function formatJoueurs($min, $max) {
    if ($min === 1 && $max === 1) {
        return "Solo";
               }
                 if ($min === $max) {
                   return $min . " joueurs";
           }
                     return $min . " à " . $max . " joueurs";
}


function categorieDuree($dureeMinutes) {
    if ($dureeMinutes < 30) {
        return "Partie rapide";
         }
            if ($dureeMinutes <= 90) {
                return "Partie moyenne";
         }
            return "Partie longue";
}

?>