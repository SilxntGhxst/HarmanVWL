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
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Contracts\Translation\TranslatorInterface;

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
    public function inscribirEquipo(Request $request, Torneo $torneo, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(InscripcionType::class, null, [
            'torneo_actual' => $torneo
        ]);
        $form->handleRequest($request);

        if ($torneo->getEstado() !== \App\Enum\EstadoTorneo::INSCRIPCIONES) {
            $this->addFlash('error', $translator->trans('flash.torneo.not_in_inscription'));
            return $this->redirectToRoute('app_torneo_show', ['id' => $torneo->getId()]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\Equipo $equipo */
            $equipo = $form->get('equipo')->getData();

            $torneo->addEquipo($equipo);
            $entityManager->flush();

            $this->addFlash('success', $translator->trans('flash.torneo.inscribed'));

            return $this->redirectToRoute('app_torneo_show', ['id' => $torneo->getId()]);
        }

        return $this->render('torneo/inscribir.html.twig', [
            'torneo' => $torneo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/desinscribir/{equipo_id}', name: 'app_torneo_desinscribir', methods: ['POST'])]
    public function desinscribirEquipo(Request $request, Torneo $torneo, #[MapEntity(id: 'equipo_id')] \App\Entity\Equipo $equipo, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('desinscribir'.$equipo->getId(), $request->getPayload()->getString('_token'))) {
            $torneo->removeEquipo($equipo);
            $entityManager->flush();
            $this->addFlash('success', $translator->trans('flash.torneo.uninscribed'));
        }

        return $this->redirectToRoute('app_torneo_show', ['id' => $torneo->getId()]);
    }
}
