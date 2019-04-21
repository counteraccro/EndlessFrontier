<?php
namespace App\Service;

use Symfony\Component\Finder\Finder;
use App\Entity\Raid;
use App\Entity\Box;
use App\Entity\BoxConstraint;

class GuildInvasion extends AppService
{

    /**
     * path du fichier xml des invasions
     *
     * @var string
     */
    const XML_PATH_INVASION = DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'xml' . DIRECTORY_SEPARATOR . 'invasions';

    /**
     * path des fichiers xml de contraintes
     *
     * @var string
     */
    const XML_PATH_CONSTRAINTS = DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'xml' . DIRECTORY_SEPARATOR . 'constraints';

    /**
     * Object XML contenant l'ensemble des contraintes du raid courant
     *
     * @var object
     */
    private $xml_constraints;

    /**
     *
     * @param number $raid_number
     * @return Raid object raid
     */
    public function generateGrid($raid_number = 0)
    {
        $this->loadConstraintsXMLFile($raid_number);
        $this->saveRaidByXML($raid_number);
    }

    /**
     * Retourne le nombre de raid du fichier xml
     *
     * @return string[]
     */
    public function getListRaidByXML()
    {
        $absoluteFilePath = $this->getAbsolutPathOfXML(dirname(__DIR__) . self::XML_PATH_INVASION);
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
        $absoluteFilePath = $this->getAbsolutPathOfXML(dirname(__DIR__) . self::XML_PATH_INVASION);

        $xml = simplexml_load_file($absoluteFilePath);
        $raid_number = (integer) $raid_number;

        if (! isset($xml->raidList[$raid_number])) {
            throw new \Exception("this raid doesnt exist");
        }

        $raid = new Raid();
        $raid->setNumero((int) $xml->raidList[$raid_number]->kindNum[0]);
        $this->persist($raid);

        foreach ($xml->raidList[$raid_number]->raid as $element) {
            $box = new Box();
            foreach ($element as $key => $value) {

                $methode = 'set' . ucfirst($key);
                $box->{$methode}((string) $value);
            }

            $box = $this->addConstaint($box);
            $this->persist($box);

            $raid->addBox($box);
        }
        $this->flush();

        return $raid->getId();
    }

    /**
     * Ajoute les contraintes associé à l'invasion pour chaque case
     *
     * @param Box $box
     * @return \App\Entity\Box
     */
    private function addConstaint(Box $box)
    {
        foreach ($this->xml_constraints->raid as $contraint) {

            if ($contraint->blockId == $box->getBlockId()) {
                $boxConstraint = new BoxConstraint();
                $boxConstraint->setNbOpen((int)$contraint->nbOpen);
                $boxConstraint->setBox($box);

                $this->persist($boxConstraint);

                $box->addBoxConstraint($boxConstraint);
            }
        }
        return $box;
    }

    /**
     * Charge un fichier de contrainte en fonction du raid
     *
     * @param int $raid_number
     */
    private function loadConstraintsXMLFile(int $raid_number)
    {
        $absolutePath = $this->getAbsolutPathOfXML(dirname(__DIR__) . self::XML_PATH_CONSTRAINTS);

        $absolutePath = substr($absolutePath, 0, - 5);
        $absolutePath = $absolutePath . ($raid_number + 1) . ".xml";

        $this->xml_constraints = simplexml_load_file($absolutePath);
    }

    /**
     * Retourne le chemin absolu de l'XML
     *
     * @throws \Exception
     * @return string
     */
    private function getAbsolutPathOfXML(string $path)
    {
        $finder = new Finder();
        $finder->files()->in($path);

        if ($finder->count() > 1 && $path == self::XML_PATH_INVASION) {
            throw new \Exception("Several files have been detected, only one file must be present");
        }

        foreach ($finder as $file) {
            $absoluteFilePath = $file->getRealPath();
        }

        return $absoluteFilePath;
    }
}