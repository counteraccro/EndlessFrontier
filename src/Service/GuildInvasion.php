<?php
namespace App\Service;

use Symfony\Component\Finder\Finder;
use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;
use App\Entity\Raid;
use App\Entity\Box;

class GuildInvasion extends AppService
{

    /**
     * path du fichier xml
     *
     * @var string
     */
    const XML_PATH = DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'xml';

    /**
     * Object doctrine
     *
     * @var Doctrine
     */
    private $doctrine;

    /**
     *
     * @param Doctrine $doctrine
     */
    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     *
     * @param number $raid_number
     * @return Raid object raid
     */
    public function generateGrid($raid_number = 0)
    {
        $this->saveRaidByXML($raid_number);
    }

    /**
     * Retourne le nombre de raid du fichier xml
     * @return string[]
     */
    public function getListRaidByXML()
    {
        $absoluteFilePath = $this->getAbsolutPathOfXML();
        $xml = simplexml_load_file($absoluteFilePath);

        $return = array();
        for ($i = 0; $i < count($xml->raidList); $i ++) {
            $return[$i] = 'Grille n°' . ($i + 1) . ' [Nb Cases:' . count($xml->raidList[$i]->raid) . ']';
        }  
        return $return;
    }

    /**
     * Permet de sauvegarder un raid en fonction de son numéro depuis un fichier xml
     *
     * @param number $raid_number
     * @throws \Exception
     * @return number id du raid enregistrer
     */
    private function saveRaidByXML($raid_number = 0)
    {
        $absoluteFilePath = $this->getAbsolutPathOfXML();

        $xml = simplexml_load_file($absoluteFilePath);
        $raid_number = (integer)$raid_number;
        
        if(!isset($xml->raidList[$raid_number]))
        {
            throw new \Exception("this raid doesnt exist");
        }
        
        $em = $this->doctrine->getManager();

        $raid = new Raid();
        $raid->setNumero((int) $xml->raidList[$raid_number]->kindNum[0]);
        $em->persist($raid);

        foreach ($xml->raidList[$raid_number]->raid as $element) {
            $box = new Box();
            foreach ($element as $key => $value) {

                $methode = 'set' . ucfirst($key);
                $box->{$methode}((string) $value);
                $em->persist($box);
            }
            $raid->addBox($box);
        }
        $em->flush();

        return $raid->getId();
    }

    /**
     * Retourne le chemin absolu de l'XML
     *
     * @throws \Exception
     * @return string
     */
    private function getAbsolutPathOfXML()
    {
        $path = dirname(__DIR__) . self::XML_PATH;

        $finder = new Finder();
        $finder->files()->in($path);

        if ($finder->count() > 1) {
            throw new \Exception("Several files have been detected, only one file must be present");
        }

        foreach ($finder as $file) {
            $absoluteFilePath = $file->getRealPath();
        }

        return $absoluteFilePath;
    }
}