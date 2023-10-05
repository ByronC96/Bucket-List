<?php

namespace App\Controller;

use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main_home')]
    public function home(){
        return $this->render('main/home.html.twig');
    }
    #[Route('/about_us', name: 'app_main_aboutus')]
    public function about_us(): \Symfony\Component\HttpFoundation\Response
    {
        //Récupérer le contenu du json
        $jsonContent = file_get_contents(__DIR__.'/../../data/team.json');
        //Parser en php array
        $team = json_decode($jsonContent, true);
        //Formatage
        foreach ($team as &$member){
            $date = new \DateTime($member['dateOfBirth']);
            $member['dateOfBirth'] = $date->format('d-m-Y');
        }
        return $this->render('main/aboutus.html.twig', [
            'team' => $team,
        ]);
    }
    
    
    
}