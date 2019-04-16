<?php
namespace App\Service;

use Doctrine\Common\Persistence\ManagerRegistry as Doctrine;

class AppService
{

    /**
     * Object doctrine
     *
     * @var Doctrine
     */
    protected $doctrine;
    
    /**
     *
     * @param Doctrine $doctrine
     */
    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    /**
     * Permet de formater la sortie de print_r
     *
     * @param mixed $data
     */
    protected function pre($data)
    {
        echo '<pre>';
        echo print_r($data);
        echo '</pre>';
    }
    
    /**
     * Retour un repository
     * @param string $class
     * @return object
     */
    protected function getRepository($class)
    {
        return $this->doctrine->getRepository($class);
    }
}