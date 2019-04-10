<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GuildInvasionController extends AbstractController
{
    /**
     * @Route("/guild/invasion", name="guild_invasion")
     */
    public function index()
    {
        return $this->render('guild_invasion/index.html.twig', [
            'controller_name' => 'GuildInvasionController',
        ]);
    }
}
