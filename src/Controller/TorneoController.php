<?php

namespace App\Controller;

use App\Entity\Torneo;
use App\Form\TorneoType;
use App\Form\InscripcionType; // <-- IMPORTANTE: No olvidar importar el nuevo formulario
use App\Repository\TorneoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Esta ruta base hace que todo lo de adentro empiece con /torneo
#[Route('/torneo')]
class TorneoController extends AbstractController
{
    #[Route('/', name: 'app_torneo_index', methods: ['GET'])]
    public function index(TorneoRepository $torneoRepository): Response
    {
        return $this->render('torneo/index.html.twig', [
            'torneos' => $torneoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_torneo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $torneo = new Torneo();
        $form = $this->createForm(TorneoType::class, $torneo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($torneo);
            $entityManager->flush();

            return $this->redirectToRoute('app_torneo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('torneo/new.html.twig', [
            'torneo' => $torneo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_torneo_show', methods: ['GET'])]
    public function show(Torneo $torneo): Response
    {
        return $this->render('torneo/show.html.twig', [
            'torneo' => $torneo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_torneo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Torneo $torneo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TorneoType::class, $torneo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_torneo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('torneo/edit.html.twig', [
            'torneo' => $torneo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_torneo_delete', methods: ['POST'])]
    public function delete(Request $request, Torneo $torneo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$torneo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($torneo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_torneo_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/inscribir', name: 'app_torneo_inscribir', methods: ['GET', 'POST'])]
    public function inscribirEquipo(Request $request, Torneo $torneo, EntityManagerInterface $entityManager): Response
    {
        // 1. Instanciamos el formulario y le pasamos la variable para el QueryBuilder
        $form = $this->createForm(InscripcionType::class, null, [
            'torneo_actual' => $torneo
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \App\Entity\Equipo $equipoSeleccionado */
            $equipoSeleccionado = $form->get('equipo')->getData();

            // 2. La lógica orientada a objetos (añadir a la colección)
            $torneo->addEquipo($equipoSeleccionado);

            // 3. Sincronizar con la base de datos
            $entityManager->flush();

            $this->addFlash('success', 'Equipo inscrito correctamente al torneo.');
            return $this->redirectToRoute('app_torneo_show', ['id' => $torneo->getId()]);
        }

        return $this->render('torneo/inscribir.html.twig', [
            'torneo' => $torneo,
            'form' => $form,
        ]);
    }
}
