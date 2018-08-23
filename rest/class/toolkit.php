<?php
class toolkit
{
    public function __construct(){
    }

    public function removeAcentos($string, $slug = false)
        {
            // Código ASCII das vogais
            $ascii['a'] = range(224, 230);
            $ascii['e'] = range(232, 235);
            $ascii['i'] = range(236, 239);
            $ascii['o'] = array_merge(range(242, 246), array(240, 248));
            $ascii['u'] = range(249, 252);
            // Código ASCII dos outros caracteres
            $ascii['b'] = array(223);
            $ascii['c'] = array(231);
            $ascii['d'] = array(208);
            $ascii['n'] = array(241);
            $ascii['y'] = array(253, 255);
            foreach ($ascii as $key => $item) {
                $acentos = '';
                foreach ($item as $codigo) {
                    $acentos .= chr($codigo);
                }

                $troca[$key] = '/[' . $acentos . ']/i';
            }

            $string = preg_replace(array_values($troca), array_keys($troca), $string);
            // Slug?
            if ($slug) {
                // Troca tudo que não for letra ou número por um caractere ($slug)
                $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
                // Tira os caracteres ($slug) repetidos
                $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
                $string = trim($string, $slug);
            }

            return strtoupper($string);
        }


    public function validaCPF($cpf = null)
    {

        // Verifica se um n?mero foi informado
        if (empty($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $cpf = preg_replace('[^0-9]$', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados ? igual a 11
        if (strlen($cpf) != 11) {
            return false;
        // Verifica se nenhuma das sequências invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        } elseif (
            $cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999'
        ) {
            return false;
            // Calcula os digitos verificadores para verificar se o
            // CPF ? v?lido
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }
}
?>