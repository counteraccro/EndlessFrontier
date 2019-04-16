<?php
namespace App\Service;

use App\Entity\Member;

/**
 * Service qui va calculer le score d'un membre de la guilde pour définir le niveau max contre un boss
 * @author count
 *
 */
class MemberScoreCalculation extends AppService
{
    /**
     * Calcul du score
     * @param Member $member
     */
    public function calculationScore(Member $member)
    {
        return $member->getKl() + $member->getBonusMalus();
    }
}