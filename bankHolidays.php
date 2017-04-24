<?php
//declare(strict_types=1);
namespace tipounet\bankHolidays;

/**
 * BankHolidayUtils
 */
final class BankHolidayUtils
{
    /**
     *
     * Déterminer la date de pâque dans le calendrier Julien
     * Méthode de Gauss
     *
     * @param $year
     * @return \DateTime
     */
    function getJulianEasterDay($year): \DateTime
    {
        $a = $year % 19;
        $b = $year % 4;
        $c = $year % 7;
        $d = ((19 * $a) + 15) % 30;
        $e = ((2 * $b) + (4 * $c) + (6 * $d) + 6) % 7;

        // nb de jour de mars (peux être supérieur a 31, dans ce cas c'est en avril)
        $month = 3;
        $h = $day = (22 + $d + $e);
        if ($h > 31) {
            $month = 4;
            $day = ($d + $e - 9);
        }

        return new \DateTime($year . '-' . $month . '-' . $day);
    }

    /**
     * FIXME : se vautre complétement alors quel l'autre méthode fonctionne, c'estun copier / collé de la méthode java qui fonctionne :'(
     * Calcul le jour de paques pour l'annee
     * <p>
     * Algorithme de Butcher, méthode de Meeus
     * https://fr.wikipedia.org/wiki/Calcul_de_la_date_de_P%C3%A2ques_selon_la_m%C3%A9thode_de_Meeus#Calcul_de_la_date_de_P.C3.A2ques_gr.C3.A9gorienne
     *
     * @param year
     * @return
     */
    function getEasterDayMeesMethode($year): \DateTime
    {
        $cycleMeton = $year % 19;
        $centaine = $year / 100;
        $rang = $year % 100;

        $siecleBissextile = $centaine / 4;
        $siecleBissextileReste = $centaine % 4;
        $cycleProemptose = ($centaine + 8) / 25;

        $proemptose = ($centaine - $cycleProemptose + 1) / 3;
        $epacte = (19 * $cycleMeton + $centaine - $siecleBissextile - $proemptose + 15) % 30;
        $anneeBissextile = $rang / 4; //b
        $anneeBissextileReste = $rang % 4; // d
        $lettreDominicale = ((2 * $siecleBissextileReste) + (2 * $anneeBissextile) - $epacte - $anneeBissextileReste + 32) % 7;
        $correction = ($cycleMeton + (11 * $epacte) + (22 * $lettreDominicale)) / 451;

        $tmp = $epacte + $lettreDominicale - (7 * $correction) + 114;
        $m = $tmp / 31;
        $day = ($tmp % 31) + 1;

        $month = 4;
        if ($m == 3) {
            $month = 3;
        }
        $retour = new \DateTime();
        $retour->setDate($year, $month, $day);
        $retour->setTime(0, 0, 0);
        return $retour;
    }

    /**
     * Calcul le jour de pâque pour l'année en paramètre avec la méthode de Conway
     * https://fr.wikipedia.org/wiki/Calcul_de_la_date_de_P%C3%A2ques_selon_la_m%C3%A9thode_de_Conway
     *
     * @param year
     * @return
     */
    public function getEasterDayConwayMethod($year): \DateTime
    {
        $s = $year / 100;//annnée séculaire
        $t = $year % 100; // millésime
        $a = $t / 4;// terme bissextil
        $p = $s % 4;
        $jps = (9 - 2 * $p) % 7; // jour pivot séculaire
        $jp = ($jps + $t + $a) % 7; // jout-pivot de l'année courante
        $g = $year % 19;
        $G = $g + 1; // Cycle de Méton
        $b = $s / 4; // Métemptose
        $r = (8 * ($s + 11)) / 25; //Proemptose

        $C = -$s + $b + $r;//Correction séculaire

        $d = (((11 * $G + $C) % 30) + 30) % 30;//Pleine lune pascale

        $h = (551 - 19 * $d + $G) / 544;// Correction des exceptions à l'épacte

        $e = (50 - $d - $h) % 7;// écart de la pleine lune pascale au jour-pivot
        $f = ($e + $jp) % 7; // jour de la plene lune pascale

        $R = 57 - $d - $f - $h; // Dimanche de paques

        $day = null;
        $month = null;
        if ($R <= 31) {
            $day = $R;
            $month = 3;
        } else {
            $month = 4;
            $day = $R - 31;
        }

        $retour = new \DateTime();
        $retour->setDate($year, $month, $day);
        $retour->setTime(0, 0, 0);
        return $retour;
    }

    /**
     * Retour le jour de pâque pour l'année en paramètre.
     * C'est calculée par une fonction interne php.
     * @param $year
     * @return \DateTime
     */
    public function getEasterDay($year): \DateTime
    {
        $retour = new \DateTime();
        $retour->setTimestamp(easter_date($year));
        return $retour;
    }

    public function getMondayOfEasterDay(\DateTime $esterDay): \DateTime
    {
        $retour = clone($esterDay);
        $retour->add(new \DateInterval('P1D'));
        return $retour;
    }

    public function getAscension(\DateTime $esterDay): \DateTime
    {
        $retour = clone($esterDay);
        $retour->add(new \DateInterval('P39D'));
        return $retour;
    }

    public function getMondayOfPentecote(\DateTime $esterDay): \DateTime
    {
        $retour = clone($esterDay);
        $retour->add(new \DateInterval('P50D'));
        return $retour;
    }

    public function isBankHoliday(\DateTime $d): bool
    {
        $retour = false;
        if ($d !== null && is_a($d, '\DateTime')) {
            $year = $d->format('Y');
            $easterDay = $this->getEasterDay($year);
            $holidays = [
                new \DateTime($year . '-1-1'),
                new \DateTime($year . '-5-1'),
                new \DateTime($year . '-5-8'),
                new \DateTime($year . '-7-14'),
                new \DateTime($year . '-8-15'),
                new \DateTime($year . '-11-1'),
                new \DateTime($year . '-11-11'),
                new \DateTime($year . '-12-25'),
                new \DateTime($year . '-12-31'),
                $easterDay,
                $this->getAscension($easterDay),
                $this->getMondayOfEasterDay($easterDay),
                $this->getMondayOfPentecote($easterDay)
            ];
            foreach ($holidays as $holiday) {
                if ($holiday == $d) {
                    $retour = true;
                    break;
                }
            }
        }
        return $retour;
    }

}