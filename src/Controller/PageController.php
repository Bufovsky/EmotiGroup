<?php

namespace App\Controller;

use App\Controller\ReservationsController;
use App\Form\ReservationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Summary of PageController
 */
#[Route('/', name: 'page.')]
class PageController extends AbstractController
{
    /**
     * Summary of index
     * @return Response
     */
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index()
    {
        $form = $this->createForm(ReservationFormType::class);

        return $this->render('reservations/index.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * Summary of result
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Controller\ReservationsController $reservationsController
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/', name: 'create', methods: ['POST'])]
    public function result(
        Request $request,
        ReservationsController $reservationsController
    ): Response {
        $form = $this->createForm(ReservationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $request = Request::create('/', 'POST', $form->getData());
            $response = $reservationsController->create($request);

            return $this->render('reservations/success.html.twig', [
                'result' => $response->getContent()
            ]);
        }

        return $this->render('reservations/index.html.twig', [
            'form' => $form
        ]);
    }
}
