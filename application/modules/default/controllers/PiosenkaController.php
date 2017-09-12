<?php

/**
 * Created by PhpStorm.
 * User: Przemo
 * Date: 2017-09-12
 * Time: 19:00
 */
class PiosenkaController extends Saffron_AbstractController
{

    public function jadaJadaMisieAction()
    {
        $this->view->tytul = 'Jadą, jadą misie';
    }

    public function kolkoGraniasteAction()
    {
        $this->view->tytul = 'Kółko graniaste';
    }

    public function ojciecISynAction()
    {
        $this->view->tytul = 'Ojciec i syn';
    }
}