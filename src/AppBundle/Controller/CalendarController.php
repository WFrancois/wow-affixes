<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CalendarController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('calendar.html.twig');
    }
}
