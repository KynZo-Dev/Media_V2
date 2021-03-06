<?php

namespace App\Controller;

use App\Entity\Books;
use App\Form\BooksType;
use App\Repository\BooksRepository;
use App\Entity\Reservations;
use App\Repository\ReservationsRepository;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catalogue')]
class BooksController extends AbstractController
{
    #[Route('/', name: 'app_books_index', methods: ['GET'])]
    public function index(BooksRepository $booksRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('books/index.html.twig', [
            'books' => $booksRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_books_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BooksRepository $booksRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EMPLOY');
        $book = new Books();
        $form = $this->createForm(BooksType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imgcouverture = $form->get('CoverImage')->getData();
            $fichier = md5(uniqid()) . '.' . $imgcouverture->guessExtension();
            $imgcouverture->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            $book->setCoverImage($fichier);
            $booksRepository->add($book, true);

            return $this->redirectToRoute('app_books_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('books/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_books_show', methods: ['GET'])]
    public function show(Books $book): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('books/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/resa', name: 'app_books_resa', methods: ['GET', 'POST'])]
    public function resa(Books $book, BooksRepository $booksRepository, ReservationsRepository $reservationsRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $reservation = new Reservations();
        $resaat = new DateTime('now');
        $resamaxat = new DateTime('now');
        $resamaxat = $resamaxat->add(new DateInterval('P3D'));
        $reservation->setReservationsAt($resaat);
        $reservation->setReservationsMaxAt($resamaxat);
        $reservation->setUser($this->getUser());
        $reservation->setBooks($book);
        $reservation->setRemove(false);
        $book->setAvailable(false);
        $booksRepository->add($book, true);
        $reservationsRepository->add($reservation, true);
        return $this->redirectToRoute('app_books_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_books_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Books $book, BooksRepository $booksRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EMPLOY');
        $form = $this->createForm(BooksType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imgcouverture = $form->get('CoverImage')->getData();
            if ($imgcouverture != null) {
                $fichier = md5(uniqid()) . '.' . $imgcouverture->guessExtension();
                $imgcouverture->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $nom = $book->getCoverImage();
                unlink($this->getParameter('images_directory').'/'.$nom);
                $book->setCoverImage($fichier);
            }
            $booksRepository->add($book, true);

            return $this->redirectToRoute('app_books_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('books/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_books_delete', methods: ['POST'])]
    public function delete(Request $request, Books $book, BooksRepository $booksRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $nom = $book->getCoverImage();
            unlink($this->getParameter('images_directory').'/'.$nom);
            $booksRepository->remove($book, true);
        }

        return $this->redirectToRoute('app_books_index', [], Response::HTTP_SEE_OTHER);
    }
}
