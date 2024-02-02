<?php

namespace App\Controller;

use App\Entity\Cake;
use App\Form\CakeType;
use App\Repository\CakeRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cake')]
class CakeController extends AbstractController
{
    #[Route('/', name: 'app_cake_index', methods: ['GET'])]
    public function index(CakeRepository $cakeRepository): Response
    {
        return $this->render('cake/index.html.twig', [
            'cakes' => $cakeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cake_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cake = new Cake();
        $form = $this->createForm(CakeType::class, $cake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cake);
            $entityManager->flush();

            return $this->redirectToRoute('app_cake_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cake/new.html.twig', [
            'cake' => $cake,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/', name: 'app_cake_show', methods: ['GET'])]
    public function show(Cake $cake = null, CommentRepository $commentRepository): Response
    {
        if (!$cake) {
            throw $this->createNotFoundException('Le gâteau n\'existe pas.');
        }

        $comments = $commentRepository->findBy(['cake' => $cake]);
        dump($cake);
        return $this->render('cake/show.html.twig', [
            'cake' => $cake,
            'comments' => $comments,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_cake_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cake $cake, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CakeType::class, $cake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cake_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cake/edit.html.twig', [
            'cake' => $cake,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cake_delete', methods: ['POST'])]
    public function delete(Request $request, Cake $cake, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cake->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cake);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cake_index', [], Response::HTTP_SEE_OTHER);
    }
}
