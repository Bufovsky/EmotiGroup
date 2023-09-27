<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Summary of ReservationsController
 */
#[Route('/v1/api', name: 'apireservations.')]
class ReservationsController extends ReservationsCrudController
{
    /**
     * Summary of get
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/reservations/{id}', name: 'get', methods: ['get'], requirements: ['id' => '\d+'])]
    public function get(string $id): JsonResponse
    {
        return parent::getAction($id);
    }

    /**
     * Summary of getList
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/reservations', name: 'getList', methods: ['get'])]
    #[IsGranted('ROLE_USER')]
    public function getList(Request $request): JsonResponse
    {
        return parent::getListAction($request);
    }

    /**
     * Summary of create
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/reservations', name: 'create', methods: ['post'])]
    public function create(Request $request): JsonResponse
    {
        return parent::createAction($request);
    }

    /**
     * Summary of delete
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/reservations/{id}', name: 'delete', methods: ['delete'], requirements: ['id' => '\d+'])]
    public function delete(string $id): JsonResponse
    {
        return parent::deleteAction($id);
    }
}
