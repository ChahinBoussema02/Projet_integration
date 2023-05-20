<?php

namespace App\Controller;

use App\Entity\AD;
use App\Form\ADType;
use App\Repository\ADRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ad')]
class ADController extends AbstractController
{
    #[Route('/', name: 'app_a_d_index', methods: ['GET'])]
    public function index(ADRepository $aDRepository): Response
    {
        return $this->render('ad/index.html.twig', [
            'a_ds' => $aDRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_a_d_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ADRepository $aDRepository): Response
    {
        $aD = new AD();
        $form = $this->createForm(ADType::class, $aD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aDRepository->save($aD, true);

            return $this->redirectToRoute('app_a_d_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ad/new.html.twig', [
            'a_d' => $aD,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_a_d_show', methods: ['GET'])]
    public function show(AD $aD): Response
    {
        return $this->render('ad/show.html.twig', [
            'a_d' => $aD,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_a_d_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AD $aD, ADRepository $aDRepository): Response
    {
        $form = $this->createForm(ADType::class, $aD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aDRepository->save($aD, true);

            return $this->redirectToRoute('app_a_d_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ad/edit.html.twig', [
            'a_d' => $aD,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_a_d_delete', methods: ['POST'])]
    public function delete(Request $request, AD $aD, ADRepository $aDRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aD->getId(), $request->request->get('_token'))) {
            $aDRepository->remove($aD, true);
        }

        return $this->redirectToRoute('app_a_d_index', [], Response::HTTP_SEE_OTHER);
    }
}
