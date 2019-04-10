<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GuildInvasion;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(GuildInvasion $guildInvasion)
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => $guildInvasion->generateGrid(),
        ]);
        
    }
}
