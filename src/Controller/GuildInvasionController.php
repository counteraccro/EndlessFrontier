<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GuildInvasion;

class GuildInvasionController extends AbstractController
{
    /**
     * @Route("/guild/invasion", name="guild_invasion_index")
     */
    public function index(GuildInvasion $guildInvasion)
    {
        return $this->render('guild_invasion/index.html.twig', [
            'controller_name' => $guildInvasion->generateGrid(),
        ]);
    }
}
