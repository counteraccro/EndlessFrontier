<?php
namespace App\Service;

use App\Entity\Raid;
use App\Entity\Member;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use App\Entity\Log;
use App\Entity\BoxInfo;
use App\Entity\BoxMember;
use App\Entity\Box;
use App\Entity\BoxConstraint;

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
    const NB_TICKET = 2;

    /**
     * Nombre de jours que dure une invasion
     *
     * @var integer
     */
    const NB_DAY = 4;

    /**
     * Nombre de fois que l'on peut ouvrir une case
     *
     * @var integer
     */
    const NB_OPEN_BOX = 3;

    /**
     * Nombre de level à ajouter après la mort d'un boss
     *
     * @var integer
     */
    const LEVEL_ADD_DEATH_BOSS = 50;

    /**
     * Nombre de case maximal de la grille en longueur
     *
     * @var integer
     */
    const NB_GRID_ROW = 13;

    /**
     * Nombre de membre maximum dans une guilde
     *
     * @var integer
     */
    const MAX_MEMBERS_GUILD = 30;

    /**
     * Grille qui va servir de données Temporaire pour la simulation
     *
     * @var array
     */
    private $grid = array();

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

        if (count($this->listeMembers) > self::MAX_MEMBERS_GUILD) {
            throw new \Exception("The maximum number of guild members is ' . $this->maxMemberGuild . ', number of members detected:" . count($this->listeMembers));
        }

        $this->grid[$this->raid->getBox()
            ->first()
            ->getblockId()] = $this->raid->getBox()->first();
        $this->_simulation(1);
        
    }

    /**
     * Méthode recursive pour calculer la simulation
     *
     * @param Raid $raid
     * @param number $day
     */
    private function _simulation(int $day = 1)
    {
        $this->log('----- day ' . $day, $this->raid);

        for ($i = 0; $i < self::NB_TICKET; $i ++) {
            $listeTmpMembers = $this->listeMembers;
            $this->_memberAttack($listeTmpMembers, $i);
        }

        $this->flush();

        if ($day < self::NB_DAY) {
            return $this->_simulation($day + 1);
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
    private function _memberAttack(array $listeTmpMembers, int $currentTicket)
    {
        foreach ($this->grid as $box) {
            
            $this->defineAdjacentBox($box);
            $this->checkConstraint($box);
            
            if($box->getBoxConstraints()->count() > 0)
            {
                $boxConstraint = $box->getBoxConstraints()->last();
                
                // On check si le nombre d'ouverture max à été atteint en fonction de la contrainte
                if($boxConstraint->getNbOpen() == 0 || $box->getBoxInfo()->count() >= $boxConstraint->getNbOpen())
                {
                    continue;
                }
            }
            
            
            $tabMember = $this->defineBestMember($box, $listeTmpMembers);
            $member = $tabMember['member'];

            $this->newBoxInfo($box, $member);
            $this->newBoxMember($box, $member);

            $log = 'Ticket n°' . ($currentTicket + 1) . ' ' . $member->getName() . ' : ' . $box->getBlockId() . "(" . $box->getLevel() . ")";
            $this->log($log, $this->raid);

            unset($listeTmpMembers[$tabMember['key']]);

            $this->defineAdjacentBox($box);
            $this->checkConstraint($box);

            break;
        }

        if (count($listeTmpMembers) > 0) {
            return $this->_memberAttack($listeTmpMembers, $currentTicket);
        }

        return true;
    }

    /**
     * Retourne la liste des cases adjacentes
     *
     * @param Box $box
     */
    private function defineAdjacentBox(Box $box)
    {
        // On défini les cases adjacentes théorique gauche / droite / haut / bas
        $tmp = array(
            //$box->getBlockId() - 1,
            $box->getBlockId() + 1,
            //$box->getBlockId() - self::NB_GRID_ROW,
            $box->getBlockId() + self::NB_GRID_ROW
        );

        /** @var Box $box_b */
        foreach ($this->raid->getBox() as $box_b) {
            // Si le block id correspond alors on le rajoute à la grille
            if (in_array($box_b->getBlockId(), $tmp)) {
                $this->grid[$box_b->getBlockId()] = $box_b;
                
                $this->checkConstraint($box);
            }
        }

        $this->grid;
    }
    
    /**
     * Vérifie si une case contient une contrainte, si oui traite la contrainte
     * @param Box $box
     */
    private function checkConstraint(Box $box)
    {
        // On vérifie si la case contient au moins une contrainte
        if($box->getBoxConstraints()->count() > 0)
        {
            /** @var BoxConstraint $boxConstraint; **/
            $boxConstraint = $box->getBoxConstraints()->last();
            
            // On check si le nombre d'ouverture max à été atteint en fonction de la contrainte
            if($boxConstraint->getNbOpen() == 0 || $box->getBoxInfo()->count() >= $boxConstraint->getNbOpen())
            {
                //si c'est le cas on enlève la case de la grille
                unset($this->grid[$box->getBlockId()]);
                return true;
            }
        }
        
        //Cas la case à été ouverte plus de X fois
        if($box->getBoxInfo()->count() == self::NB_OPEN_BOX)
        {
            unset($this->grid[$box->getBlockId()]);
            return true;
        }
        
    }

    /**
     * Retourne le meilleur membre pour le boss en cours
     *
     * @param Box $box
     */
    private function defineBestMember(Box $box, array $listeTabMember)
    {
        $tabReturn = null;
        foreach ($listeTabMember as $key => $member) {
            $maxLevel = $this->memberScoreSimulation->calculationScore($member);

            if ($maxLevel >= $box->getLevel()) {
                $tabReturn = array(
                    'member' => $member,
                    'key' => $key
                );
                break;
            }
        }

        if (is_null($tabReturn)) {
            die('Attention cas à traiter');
        }

        return $tabReturn;
    }

    /**
     * Création d'un objet BoxMember
     *
     * @param Box $box
     * @param Member $member
     */
    private function newBoxMember(Box $box, Member $member)
    {
        $boxMember = new BoxMember();
        $boxMember->setMember($member);
        $boxMember->setBox($box);
        $this->persist($boxMember);
        
        $box->addBoxMember($boxMember);
        $this->grid[$box->getBlockId()] = $box;
    }

    /**
     * Création d'un objet BoxInfo
     *
     * @param Box $box
     */
    private function newBoxInfo(Box $box, Member $member)
    {
        $boxInfo = new BoxInfo();
        $boxInfo->setLevel($box->getLevel() + self::LEVEL_ADD_DEATH_BOSS);
        $boxInfo->setBox($box);
        $boxInfo->setMember($member);
        $boxInfo->setStar(0);
        $this->persist($boxInfo);

        $box->addBoxInfo($boxInfo);

        // On met à jour la grille temporaire
        $this->grid[$box->getBlockId()] = $box;
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