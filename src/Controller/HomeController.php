<?php
/**
 * Created by PhpStorm.
 * User: isak
 * Date: 1/31/18
 * Time: 9:20 AM
 */

namespace App\Controller;


use App\Service\WowWeek;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    public function __invoke(Request $request, WowWeek $wowWeek)
    {
        $isNightMode = $_COOKIE['isNightMode'] ?? 'false';
        $isNightMode = filter_var($isNightMode, FILTER_VALIDATE_BOOLEAN);

        $hideAlertNightMode = !empty($_COOKIE['hideAlertNightMode']);

        setcookie('hideAlertNightMode', 'true', time() + 60 * 60 * 24 * 30);

        if ((new \DateTimeImmutable())  > new \DateTimeImmutable('2020-03-01')) {
            $hideAlertNightMode = true;
        }

        return $this->render('homepage.html.twig', [
            'wowaffixes' => $wowWeek,
            'isNightMode' => $isNightMode,
            'hideAlertNightMode' => $hideAlertNightMode,
        ]);
    }
}