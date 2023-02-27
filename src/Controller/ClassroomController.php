<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{

    private $em;

    public function __construct(ManagerRegistry $registry)
    {
        $this->em = $registry->getManager();
    }

    #[Route('/classroom', name: 'classroom_index')]
    public function index(): Response
    {
        $classrooms = $this->em->getRepository(Classroom::class)->findAll();

        return $this->render('classroom/index.html.twig', [
            'classrooms' => $classrooms,
        ]);
    }

    /**
     * @Route("/classrooms/create", name="classroom_create")
     */
    public function create(Request $request): Response
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classroom);
            $entityManager->flush();

            return $this->redirectToRoute('classroom_index');
        }

        return $this->render('classroom/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/classrooms/{id}/edit", name="classroom_edit")
     */
    public function edit(Request $request, Classroom $classroom): Response
    {
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classroom_index');
        }

        return $this->render('classroom/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    // public function delete(Request $request, Classroom $classroom): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$classroom->getId(), $request->request->get('_token'))) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($classroom);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('classroom_index');
    // }

}
