<?php
class library
{
    //recuerda la funcion strtr() hace lo mismo
    function filtrar($cadena, $reemplazar)
    {
        $cadena_final = $cadena;
        foreach($reemplazar as $key => $value)
        {
                $cadena_final = str_replace($key, $value, $cadena_final);
        }

        return $cadena_final;
    }

    function substract_inicio($source, $inicio)
    {
        $pos_inicio = strpos($source, $inicio) + strlen($inicio);
        return substr($source, $pos_inicio);
    }

    function substract_final($source, $final)
    {
            $pos_final = strpos($source, $final);
            return substr($source, 0, $pos_final);
    }

    function obtener_contenidos($url, $inicio, $final)
    {
        $source = file_get_contents($url);
        //$source = @file_get_contents("www.sbs.gob.pe/app/stats/tc-cv.asp?FECHA_CONSULTA=16/11/2016'&button22=Consultar");
        var_dump($source);exit;
        $source = mb_convert_encoding($source, 'UTF-8', mb_detect_encoding($source, 'UTF-8, ISO-8859-1', true));
        if(!$source)
        {
            return false;
        }
        $source = $this->substract_inicio($source, $inicio);
        $found_text = $this->substract_final($source, $final);

        var_dump($final);exit;
        exit;
        $found_text = preg_replace(array('//Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$found_text));
        return $found_text;
    }

    function record_sort($records, $field, $reverse=false)
    {
        $hash = array();
        foreach($records as $record)
        {
            $hash[$record[$field]] = $record;
        }
        ($reverse)? krsort($hash) : ksort($hash);
        $records = array();
        foreach($hash as $record)
        {
            $records []= $record;
        }
        return $records;
    }

    function hex2rgb($hex) 
    {
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) 
        {
              $r = hexdec(substr($hex,0,1).substr($hex,0,1));
              $g = hexdec(substr($hex,1,1).substr($hex,1,1));
              $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } 
        else
        {
              $r = hexdec(substr($hex,0,2));
              $g = hexdec(substr($hex,2,2));
              $b = hexdec(substr($hex,4,2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }

    function insertar_label( $background, $text, $x, $y, $color, $size, $font )
    {
        $color = $this->hex2rgb($color);
        $color_red = $color[0];
        $color_green = $color[1];
        $color_blue = $color[2];
        $im = imagecreatetruecolor(150, 25);
        $color = imagecolorallocate( $im, $color_red, $color_green, $color_blue );
        return imagettftext($background, $size, 0, $x, $y, $color, $font, $text);
    }

    function mostrar_error_jpg($error)
    {
        $im = imagecreatetruecolor(480, 200);
        $font = "fonts/ttf/OpenSans-Regular_5.ttf";
        $this->insertar_label( $im, $error, 90, 100, "#ff0000", 15, $font );
        header('Content-type: image/jpg');
        imagejpeg($im, NULL, 100);
        imagedestroy($im);
    }
}
?>