<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/v1/api', name: 'apireservations.')]
class ReservationsController extends ReservationsCrudController
{
    #[Route('/reservations/{id}', name: 'get', methods:['get'], requirements: ['id' => '\d+'] )]
    public function get(string $id) : JsonResponse
    {
        return parent::getAction($id);
    }

    #[Route('/reservations', name: 'getList', methods:['get'] )]
    //#[Security('is_granted("ROLE_API_USER")')]
    #[IsGranted('ROLE_USER')]
    public function getList(Request $request) : JsonResponse
    {
        return parent::getListAction($request);
    }
 
    #[Route('/reservations', name: 'create', methods:['post'] )]
    public function create(Request $request) : JsonResponse
    {
        return parent::createAction($request);
    }
 
    #[Route('/reservations/{id}', name: 'delete', methods:['delete'], requirements: ['id' => '\d+'] )]
    public function delete(string $id) : JsonResponse
    {
        return parent::deleteAction($id);
    }
}
