<?php

namespace App\Controller;

use App\Model\EventManager;
use App\Model\MapsManager;

class EventController extends AbstractController
{
    public function list()
    {
        $eventManager = new EventManager();
        $events = $eventManager->selectAll();

        $mapsManager = new MapsManager();
        $map = $mapsManager->selectAll();

        return $this->twig->render('Event/show.html.twig', ['events' => $events, 'maps' => $map]);
    }
}
