<?php
/**
 * 
 *******************************************************************************
 * <hr>
 * Plik: <b>MtpUtils.php</b><br> 
 * Autor: <b>Mariusz Winiarz</b><br>
 * Firma: <b>Qbix-Soft</b><br>
 * Data utworzenia: <b>13-05-2014</b><br>
 * <hr>
 *******************************************************************************
 * Klasa zawierajace rozne przydatne funkcje wykorzystywane w calej aplikacji 
 *******************************************************************************
 * <hr> 
 * @author mariusz 
 *******************************************************************************
 */
class MtpUtils
{
    public static function zamienRokDlaPolrocznika($pmYr)
    {
        switch($pmYr)
        {
            case "06": $lvZamienionyRok = "2006"; break;
            case "07": $lvZamienionyRok = "2007"; break;
            case "08": $lvZamienionyRok = "2008"; break;
            case "09": $lvZamienionyRok = "2009"; break;
            case "10": $lvZamienionyRok = "2010"; break;
            case "11": $lvZamienionyRok = "2011"; break;
            case "12": $lvZamienionyRok = "2012"; break;
            case "131": $lvZamienionyRok = "2013 1st"; break;
            case "132": $lvZamienionyRok = "2013 2nd"; break;
            case "141": $lvZamienionyRok = "2014 1st"; break;
            case "142": $lvZamienionyRok = "2014 2nd"; break;
            case "151": $lvZamienionyRok = "2015 1st"; break;
            case "152": $lvZamienionyRok = "2015 2nd"; break;
            case "161": $lvZamienionyRok = "2016 1st"; break;
            case "162": $lvZamienionyRok = "2016 2nd"; break;
            case "171": $lvZamienionyRok = "2017 1st"; break;
            case "172": $lvZamienionyRok = "2017 2nd"; break;
            default: $lvZamienionyRok = $pmYr; break;
        }
        return $lvZamienionyRok;
    }
}
?>

