<?php
/**
 * Created by PhpStorm.
 * User: isak
 * Date: 1/31/18
 * Time: 9:20 AM
 */

namespace App\Controller;


use App\Service\WowWeek;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function __invoke(WowWeek $wowWeek)
    {
        return $this->render('homepage.html.twig', [
            'wowaffixes' => $wowWeek,
        ]);
    }
}