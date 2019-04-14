<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Member;

class MemberFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        $tabMember = array(
            0 => array('Porky','495','-65'),
            1 => array('bartreaper','501','-70'),
            2 => array('Pramxnim','504','-60'),
            3 => array('Counters','502','-40'),
            4 => array('Arastaiel','506','-40'),
            5 => array('Eicar','520','-50'),
            6 => array('Jaix','514','-40'),
            7 => array('Raph','508','-10'),
            8 => array('ProProkon','523','-25'),
            9 => array('Radak','523','-20'),
            10 => array('wakka','528','-20'),
            11 => array('dydy','510','0'),
            12 => array('buha','522','-10'),
            13 => array('BlueCat','522','0'),
            14 => array('Gemesis','557','-30'),
            15 => array('rosyl','541','-10'),
            16 => array('roy','553','-7'),
            17 => array('Proton','547','0'),
            18 => array('Lijwent','549','8'),
            19 => array('wanna','551','8'),
            20 => array('Dargath','564','10'),
            21 => array('rufus','565','10'),
            22 => array('on3','567','10'),
            23 => array('Sysy','574','10'),
            24 => array('sephi','577','10'),
            25 => array('foufou','581','12'),
            26 => array('styou','584','10'),
            27 => array('flash','586','10'),
            28 => array('loki','594','10'),
            29 => array('StarDuster','595','18'),
            
        );
        
        foreach ($tabMember as $data)
        {
            $member = new Member();
            $member->setName($data[0]);
            $member->setKl($data[1]);
            $member->setBonusMalus($data[2]);
            $member->setDisabled(0);
            
            $manager->persist($member);
        }

        $manager->flush();
    }
}
