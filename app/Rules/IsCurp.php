<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsCurp implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (strlen($value) == 18) {
            $letras     = substr($value, 0, 4);
            $numeros    = substr($value, 4, 6);
            $sexo       = substr($value, 10, 1);
            $mxState    = substr($value, 11, 2);
            $letras2    = substr($value, 13, 3);
            $homoclave  = substr($value, 16, 2);
            if (ctype_alpha($letras) && ctype_alpha($letras2) && ctype_digit($numeros) && ctype_digit($homoclave) && $this->is_mx_state($mxState) && $this->is_sexo_curp($sexo)) {
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

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El curp no es valido.';
    }
}
