<?php
namespace App\Service;

use App\Entity\Raid;
use App\Entity\Member;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use App\Entity\Log;
use phpDocumentor\Reflection\Types\Object_;

/**
 * Service qui va simuler une invasion de guilde
 *
 * @author count
 *        
 */
class GuildInvasionSimulation extends AppService
{

    /**
     * Nombre de tickets par joueur et par jour
     *
     * @var integer
     */
    private $nb_ticket = 2;

    /**
     * Nombre de jours que dure une invasion
     *
     * @var integer
     */
    private $nb_day = 4;

    /**
     * Nombre de fois que l'on peut ouvrir une case
     *
     * @var integer
     */
    private $nb_open_box = 3;

    /**
     * Correspondance entre le niveau d'un boss et une étoile
     *
     * @var array
     */
    private $tabLevelBossEtoile = array(
        300 => 1,
        380 => 2,
        450 => 3,
        540 => 4,
        600 => 5
    );

    /**
     * Object doctrine
     *
     * @var MemberScoreCalculation
     */
    private $memberScoreSimulation;

    /**
     *
     * @param MemberScoreCalculation $doctrine
     */
    public function __construct(MemberScoreCalculation $memberScoreSimulation, Doctrine $doctrine)
    {
        $this->memberScoreSimulation = $memberScoreSimulation;
        parent::__construct($doctrine);
    }

    /**
     * Permet de simuler une invasion de guilde
     *
     * @param Raid $raid
     */
    public function simulation(Raid $raid)
    {
        $memberRepository = $this->getRepository(Member::class);
        $listeMember = $memberRepository->getListeMemberActif();

        $this->_simulation($raid, $listeMember);
    }

    /**
     * Méthode recursive pour calculer la simulation
     *
     * @param Raid $raid
     * @param number $day
     */
    private function _simulation(Raid $raid, $listeMember, $day = 1)
    {
        $tabLog = array();

        $this->log('----- day ' . $day, $raid);

        for ($i = 0; $i < $this->nb_ticket; $i ++) {

            /**
             *
             * @var Member $member
             */
            foreach ($listeMember as $member) {
                $score = $this->memberScoreSimulation->calculationScore($member);

                $tabLog[$member->getId()][] = 'Ticket n°' . ($i+1) . ' ' . $member->getName() . ' => ' . $score . ' ';
            }
        }

        // Génération des logs
        foreach($tabLog as $tabTmp)
        {
            $str = '';
            foreach($tabTmp as $strTmp)
            {
                $str .= $strTmp;
            }
            $this->log($str, $raid);
        }

        $this->flush();

        if ($day < $this->nb_day) {
            return $this->_simulation($raid, $listeMember, $day + 1);
        }

        return true;
    }

    /**
     * Permet d'enregistrer un log
     *
     * @param string $str
     * @param Raid $raid
     */
    private function log(string $str, Raid $raid)
    {
        $log = new Log();
        $log->setLog($str);
        $log->setRaid($raid);
        $this->persist($log);
    }
}