<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\ReservationsType;
use App\Repository\ReservationsRepository;
use App\Entity\Books;
use App\Form\BooksType;
use App\Repository\BooksRepository;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservations')]
class ReservationsController extends AbstractController
{
    #[Route('/', name: 'app_reservations_index', methods: ['GET'])]
    public function index(ReservationsRepository $reservationsRepository): Response
    {
        return $this->render('reservations/index.html.twig', [
            'reservations' => $reservationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservations_new', methods: ['GET', 'POST'])]
    public function new(ReservationsRepository $reservationsRepository): Response
    {
        $reservation = new Reservations();
        $resaat = new DateTime('now');
        $resamaxat = new DateTime('now');
        $resamaxat = $resamaxat->add(new DateInterval('P3D'));
        $reservation->setReservationsAt($resaat);
        $reservation->setReservationsMaxAt($resamaxat);
        $reservation->setUser($this->getUser());
        $reservationsRepository->add($reservation, true);
        return $this->redirectToRoute('app_reservations_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_reservations_show', methods: ['GET'])]
    public function show(Reservations $reservation): Response
    {
        return $this->render('reservations/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservations $reservation, ReservationsRepository $reservationsRepository): Response
    {
        $form = $this->createForm(ReservationsType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationsRepository->add($reservation, true);

            return $this->redirectToRoute('app_reservations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservations/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservations_delete', methods: ['POST'])]
    public function delete(Request $request, Reservations $reservation, ReservationsRepository $reservationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $reservationsRepository->remove($reservation, true);
        }

        return $this->redirectToRoute('app_reservations_index', [], Response::HTTP_SEE_OTHER);
    }
}
