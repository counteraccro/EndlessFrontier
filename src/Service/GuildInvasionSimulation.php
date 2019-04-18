<?php
namespace App\Service;

use App\Entity\Raid;
use App\Entity\Member;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use App\Entity\Log;
use phpDocumentor\Reflection\Types\Object_;
use App\Entity\BoxInfo;
use App\Entity\BoxMember;
use App\Entity\Box;

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
     * Nombre de level à ajouter après la mort d'un boss
     *
     * @var integer
     */
    private $levelAdditionnal = 50;

    /**
     * Nombre de case maximal de la grille en longueur
     *
     * @var integer
     */
    private $nbBoxRow = 13;

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
     * Objet raid
     *
     * @var Raid
     */
    private $raid;

    /**
     * Liste des membres
     *
     * @var array
     */
    private $listeMembers;

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
        $this->raid = $raid;

        $memberRepository = $this->getRepository(Member::class);
        $this->listeMembers = $memberRepository->getListeMemberActif();

        $grid = array();
        $grid[$this->raid->getBox()
            ->first()
            ->getblockId()] = $this->raid->getBox()->first();
        $this->_simulation(1, $grid);
    }

    /**
     * Méthode recursive pour calculer la simulation
     *
     * @param Raid $raid
     * @param number $day
     */
    private function _simulation(int $day = 1, $grid = array())
    {
        $this->log('----- day ' . $day, $this->raid);

        for ($i = 0; $i < $this->nb_ticket; $i ++) {

            $listeTmpMembers = $this->listeMembers;
            $this->_memberAttack($listeTmpMembers, $grid, $i);
        }

        $this->flush();

        if ($day < $this->nb_day) {
            return $this->_simulation($day + 1, $grid);
        }

        return true;
    }

    /**
     * Méthode récursive qui va permettre de parcourir la liste des membres
     *
     * @param array $listeTmpMembers
     * @param array $grid
     * @param int $currentTicket
     */
    private function _memberAttack(array $listeTmpMembers, array $grid, int $currentTicket)
    {
        /** @var Member $member */
        foreach ($listeTmpMembers as $key => $member) {
            $score = $this->memberScoreSimulation->calculationScore($member);

            // Cas premier jour, premier hit
            if (count($grid) == 1) {

                $box = $grid[1];
                /** @var Box $box */
                $boxInfo = new BoxInfo();
                $boxInfo->setLevel($box->getLevel() + 50);
                $boxInfo->setBox($box);
                $boxInfo->setStar(0);
                $this->persist($boxInfo);

                $boxMember = new BoxMember();
                $boxMember->setMember($member);
                $boxMember->setBox($box);
                $this->persist($boxMember);

                $log = 'Ticket n°' . ($currentTicket + 1) . ' ' . $member->getName() . ' : ' . $box->getBlockId() . "(" . $box->getLevel() . ")";

                unset($listeTmpMembers[$key]);
                
                $grid = $this->defineAdjacentBox($box, $grid);
                break;
            }
        }

        $this->log($log, $this->raid);

        if (count($listeTmpMembers) > 0) {
            return $this->_memberAttack($listeTmpMembers, $grid, $currentTicket);
        }

        return true;
    }

    /**
     * Retourne la liste des cases adjacentes
     *
     * @param Box $box
     * @param array $grid
     */
    private function defineAdjacentBox(Box $box, array $grid)
    {
        return $grid;
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