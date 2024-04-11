<?php

namespace App\Helpers;

class ValidaCurp
{

    public function validate_curp($valor)
    {
        if (strlen($valor) == 18) {
            $letras     = substr($valor, 0, 4);
            $numeros    = substr($valor, 4, 6);
            $sexo       = substr($valor, 10, 1);
            $mxState    = substr($valor, 11, 2);
            $letras2    = substr($valor, 13, 3);
            $homoclave  = substr($valor, 16, 2);
            if (ctype_alpha($letras) && ctype_alpha($letras2) && ctype_digit($numeros) && ctype_digit($homoclave) && is_mx_state($mxState) && is_sexo_curp($sexo)) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function is_mx_state($state)
    {
        $mxStates = [
            'AS', 'BS', 'CL', 'CS', 'DF', 'GT',
            'HG', 'MC', 'MS', 'NL', 'PL', 'QR',
            'SL', 'TC', 'TL', 'YN', 'NE', 'BC',
            'CC', 'CM', 'CH', 'DG', 'GR', 'JC',
            'MN', 'NT', 'OC', 'QT', 'SP', 'SR',
            'TS', 'VZ', 'ZS'
        ];
        if (in_array(strtoupper($state), $mxStates)) {
            return true;
        }
        return false;
    }

    public function is_sexo_curp($sexo)
    {
        $sexoCurp = ['H', 'M'];
        if (in_array(strtoupper($sexo), $sexoCurp)) {
            return true;
        }
        return false;
    }
}
