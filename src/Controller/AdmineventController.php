<?php

namespace App\Controller;

use App\Model\EventManager;
use App\Model\MapsManager;
use App\Service\ValidationService;

class AdmineventController extends AbstractAdminController
{

    public function listEvents()
    {
        $eventManager = new EventManager();
        $events = $eventManager->selectAllEvents();

        $mapsManager = new MapsManager();
        $map = $mapsManager->selectAll();

        return $this->twig->render('Admin/Event/index.html.twig', ['events' => $events, 'maps' => $map]);
    }

    public function deleteEvent($id)
    {
        $eventManager = new EventManager();
        $eventManager->delete($id);
        header('Location:/adminevent/listevents');
    }

    public function createEvent()
    {
        return $this->twig->render('Admin/Event/form.html.twig');
    }

    public function processEventCreation()
    {
        $validator = new ValidationService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventManager = new EventManager();

            if (
                !$validator->validateDate($_POST['date'])
                || !$validator->validateString($_POST['title'])
                || !$validator->validateString($_POST['location'])
                || !$validator->validateInt($_POST['seats'])
            ) {
                 header('Location:/adminevent/createevent/');
                 return;
            }

            $event = [
                'date' => $_POST['date'],
                'title' => $_POST['title'],
                'location' => $_POST['location'],
                'number_seat' => $_POST['seats'],
            ];
            $id = $eventManager->insert($event);
            if ($id) {
                header('Location:/adminevent/listevents');
            }
        }

        return $this->twig->render('Admin/Event/form.html.twig');
    }

    public function updateEvent($id)
    {
        $eventManager = new EventManager();
        $event = $eventManager->selectOneById($id);
        return $this->twig->render('Admin/Event/updateform.html.twig', ['event' => $event]);
    }


    public function processEventUpdate()
    {
        $validator = new ValidationService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventManager = new EventManager();

            if (
                !$validator->validateDate($_POST['date'])
                || !$validator->validateString($_POST['title'])
                || !$validator->validateString($_POST['location'])
                || !$validator->validateInt($_POST['seats'])
            ) {
                header('Location:/adminevent/updateevent/' . $_POST['event-id']);
                return;
            }
            $event = [
                'date' => $_POST['date'],
                'title' => $_POST['title'],
                'location' => $_POST['location'],
                'number_seat' => $_POST['seats'],
                'id' => $_POST['event-id']
            ];
            $eventManager->update($event);
            header('Location:/adminevent/listevents');
        }
    }

    public function updateMaps()
    {
        $mapsManager = new MapsManager();
        $map = $mapsManager->selectAll();

        return $this->twig->render('Admin/Event/updatemaps.html.twig', ['map' => $map]);
    }

    public function processUpdateMaps()
    {
        $validator = new ValidationService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mapsManager = new mapsManager();

            if (
                !$validator->validateString($_POST['url'])
            ) {
                header('Location:/adminevent/updatemaps/');
                return;
            }
            $maps = [
                'url' => $_POST['url'],
            ];
            $mapsManager->update($maps);
            header('Location:/adminevent/listevents');
        }
    }
}
