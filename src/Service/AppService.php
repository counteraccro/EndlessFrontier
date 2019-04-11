<?php
namespace App\Service;

class AppService
{

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
}