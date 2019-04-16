<?php
namespace App\Service;

use App\Entity\Raid;
use App\Entity\Member;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;

/**
 * Service qui va simuler une invasion de guilde
 * @author count
 *
 */
class GuildInvasionSimulation extends AppService
{
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
     * @param Raid $raid
     */
    public function simulation(Raid $raid)
    {
       $memberRepository = $this->getRepository(Member::class);
       $listeMember = $memberRepository->getListeMemberActif();
       
       /**
        * @var Member $member
        */
       foreach($listeMember as $member)
       {
           $score = $this->memberScoreSimulation->calculationScore($member);
           
           echo $member->getName() . ' => ' . $score . '<br />';
       }
       
       //die();
    }
    
}