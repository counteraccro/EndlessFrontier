<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Service\GuildInvasion;
use App\Entity\Raid;
use Symfony\Component\HttpFoundation\Request;

class GuildInvasionController extends AbstractController
{

    /**
     * Affiche un raid complet
     *
     * @Route("/guild/invasion", name="guild_invasion_index")
     */
    public function index(GuildInvasion $guildInvasion)
    {
        $raidRepository = $this->getDoctrine()->getRepository(Raid::class);
        $raids = $raidRepository->findAll();

        $listing_raid = $guildInvasion->getListRaidByXML();

        return $this->render('guild_invasion/index.html.twig', [
            'raids' => $raids,
            'listing_raid' => $listing_raid
        ]);
    }

    /**
     * Affiche la grille complète d'un raid
     *
     * @Route("/guild/invasion/show/{id}", name="guild_invasion_show")
     * @ParamConverter("raid", options={"mapping": {"id": "id"}})
     *
     * @param Raid $raid
     */
    public function showGrid(Raid $raid)
    {
        return $this->render('guild_invasion/show.html.twig', [
            'raid' => $raid
        ]);
    }

    /**
     * Supprime un raid
     *
     * @Route("/guild/invasion/delete/raid/{id}", name="guild_invasion_delete_raid")
     * @ParamConverter("raid", options={"mapping": {"id": "id"}})
     *
     * @param Raid $raid
     */
    public function deleteRaid(Raid $raid)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($raid);
        $entityManager->flush();

        return $this->redirectToRoute('guild_invasion_index');
    }

    /**
     * Création d'un nouveau raid
     *
     * @Route("/guild/invasion/new/raid", name="guild_invasion_new_raid")
     */
    public function addNewRaid(GuildInvasion $guildInvasion, Request $request)
    {
        $post = $request->request->all();
        if (isset($post['numero'])) {
            $guildInvasion->generateGrid($post['numero']);
        }
        return $this->redirectToRoute('guild_invasion_index');
    }
}
