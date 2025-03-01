<?php

if (!function_exists('getPoint')) {
    function getPoint($montant, $remise) {
        $netPaye = $montant*(1-$remise/100);
        $pointMax = $netPaye/100;

        if ($remise==0){
            return $pointMax;
        }
        $point=$pointMax*(1-$remise/10);
        if($point<0){
            return 0;
        }else{
            return $point;
        }
        
    }
}
if (!function_exists('formateur')) {
    function formateur($montant) {
            return number_format($montant,'0','.',' ');
    }
}
