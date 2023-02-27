<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Estudiant;
class EtudiantController extends AbstractController
{

    private $em;

    public function __construct(ManagerRegistry $registry)
    {
        $this->em = $registry->getManager();
    }


    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(): Response
    {
       $etudiants = $this->em->getRepository(Estudiant::class)->findAll();
      
       
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiants,
        ]);
    }
}
