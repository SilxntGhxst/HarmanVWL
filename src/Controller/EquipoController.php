<?php

namespace App\Controller;

use App\Entity\Equipo;
use App\Form\EquipoType;
use App\Repository\EquipoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\FichajeType;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/equipo')]
final class EquipoController extends AbstractController
{
    #[Route(name: 'app_equipo_index', methods: ['GET'])]
    public function index(EquipoRepository $equipoRepository): Response
    {
        return $this->render('equipo/index.html.twig', [
            'equipos' => $equipoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_equipo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipo = new Equipo();
        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipo);
            $entityManager->flush();

            return $this->redirectToRoute('app_equipo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipo/new.html.twig', [
            'equipo' => $equipo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipo_show', methods: ['GET'])]
    public function show(Equipo $equipo): Response
    {
        return $this->render('equipo/show.html.twig', [
            'equipo' => $equipo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_equipo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Equipo $equipo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_equipo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipo/edit.html.twig', [
            'equipo' => $equipo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipo_delete', methods: ['POST'])]
    public function delete(Request $request, Equipo $equipo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($equipo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_equipo_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/equipo/{id}/fichar', name: 'app_equipo_fichar', methods: ['GET', 'POST'])]
    public function ficharJugador(Request $request, Equipo $equipo, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        // 1. Creamos el formulario de fichaje
        $form = $this->createForm(FichajeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Obtenemos el jugador que el usuario seleccionó en el <select>
            /** @var \App\Entity\Jugador $jugadorSeleccionado */
            $jugadorSeleccionado = $form->get('jugador')->getData();

            $jugadorSeleccionado ->setEquipo($equipo);
            $entityManager->flush();

            $this->addFlash('success', $translator->trans('flash.fichaje.success'));
            return $this->redirectToRoute('app_equipo_show', ['id' => $equipo->getId()]);
        }

        return $this->render('equipo/fichar.html.twig', [
            'equipo' => $equipo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/despedir/{jugador_id}', name: 'app_equipo_despedir', methods: ['POST'])]
    public function despedirJugador(Request $request, Equipo $equipo, #[MapEntity(id: 'jugador_id')] \App\Entity\Jugador $jugador, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('despedir'.$jugador->getId(), $request->getPayload()->getString('_token'))) {
            $jugador->setEquipo(null);
            $entityManager->flush();
            $this->addFlash('success', $translator->trans('flash.equipo.player_fired'));
        }

        return $this->redirectToRoute('app_equipo_show', ['id' => $equipo->getId()]);
    }
}
