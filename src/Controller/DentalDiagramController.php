<?php

namespace App\Controller;

use App\Entity\DentalDiagram;
use App\Form\DentalDiagramType;
use App\Model\DentalData;
use App\Repository\DentalDiagramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dental/diagram')]
class DentalDiagramController extends AbstractController
{
    #[Route('/', name: 'app_dental_diagram_index', methods: ['GET'])]
    public function index(DentalDiagramRepository $dentalDiagramRepository): Response
    {
        return $this->render('dental_diagram/index.html.twig', [
            'dental_diagrams' => $dentalDiagramRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dental_diagram_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DentalDiagramRepository $dentalDiagramRepository): Response
    {
        ($dentalDiagram = new DentalDiagram())
            ->setDatas([
                new DentalData(),
                new DentalData(),
                new DentalData(),
                new DentalData(),
                new DentalData(),
                new DentalData(),
            ])
        ;

        $form = $this->createForm(DentalDiagramType::class, $dentalDiagram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dentalDiagramRepository->add($dentalDiagram, true);

            return $this->redirectToRoute('app_dental_diagram_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dental_diagram/new.html.twig', [
            'dental_diagram' => $dentalDiagram,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dental_diagram_show', methods: ['GET'])]
    public function show(DentalDiagram $dentalDiagram): Response
    {
        return $this->render('dental_diagram/show.html.twig', [
            'dental_diagram' => $dentalDiagram,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dental_diagram_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DentalDiagram $dentalDiagram, DentalDiagramRepository $dentalDiagramRepository): Response
    {
        $form = $this->createForm(DentalDiagramType::class, $dentalDiagram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dentalDiagramRepository->add($dentalDiagram, true);

            return $this->redirectToRoute('app_dental_diagram_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dental_diagram/edit.html.twig', [
            'dental_diagram' => $dentalDiagram,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dental_diagram_delete', methods: ['POST'])]
    public function delete(Request $request, DentalDiagram $dentalDiagram, DentalDiagramRepository $dentalDiagramRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dentalDiagram->getId(), $request->request->get('_token'))) {
            $dentalDiagramRepository->remove($dentalDiagram, true);
        }

        return $this->redirectToRoute('app_dental_diagram_index', [], Response::HTTP_SEE_OTHER);
    }
}
