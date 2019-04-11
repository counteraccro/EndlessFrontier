<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GuildInvasion;
use App\Entity\Raid;

class GuildInvasionController extends AbstractController
{

    /**
     *
     * @Route("/guild/invasion", name="guild_invasion_index")
     */
    public function index(GuildInvasion $guildInvasion)
    {
        $raidRepository = $this->getDoctrine()->getRepository(Raid::class);
        $raid = $raidRepository->findLastRaid();
        
        if(is_null($raid))
        {
            $guildInvasion->generateGrid();
            $raid = $raidRepository->findLastRaid();
        }
        
        
        
        return $this->render('guild_invasion/index.html.twig', [
            'raid' => $raid,
        ]);
    }
}
