<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Entity\User;
use App\Entity\Vacancies;
use App\Interface\ReservationsInterface;
use App\Interface\VacanciesInterface;
use App\Repository\UserRepository;
use App\Service\CostCalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Exception;

abstract class ReservationsCrudController extends AbstractController
{
    /**
     * Summary of __construct
     * @param \Symfony\Component\Serializer\SerializerInterface $serializer
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     * @param \App\Interface\ReservationsInterface $reservation
     * @param \App\Interface\VacanciesInterface $vacancies
     * @param \App\Service\CostCalculatorService $calculator
     */
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private ReservationsInterface $reservation,
        private VacanciesInterface $vacancies,
        private CostCalculatorService $calculator,
        private UserRepository $userRepository
    ) {
    }

    /**
     * Get a resource by its identifier.
     *
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function getAction(string $id): JsonResponse
    {
        $reservationDto = $this->reservation->get($id);

        if (null === $reservationDto) {
            return new JsonResponse(
                'Resource not found.',
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            $this->serializer->serialize(
                $reservationDto,
                'json'
            ),
            Response::HTTP_OK,
            ["Content-Type" => "application/json"],
            true
        );
    }

    /**
     * Get a list.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getListAction(Request $request): JsonResponse
    {
        try {
            $collection = $this->reservation->getList();
        } catch (Exception $e) {
            return new JsonResponse(
                'Error occurred while trying to delete the resource.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse(
            $this->serializer->serialize(
                $collection,
                'json'
            ),
            Response::HTTP_OK,
            ["Content-Type" => "application/json"],
            true
        );
    }

    /**
     * Create a new resource.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAction(Request $request): JsonResponse
    {
        $requestJson = $this->serializer->serialize($request->request->all(), 'json');
        $dto = [
            'reservations' => Reservations::class, 
            'vacancies' => Vacancies::class, 
            'user' => User::class
        ];

        foreach ( $dto as $key => $value ) {
            ${$key.'Dto'} = $this->serializer->deserialize(
                $requestJson,
                $value,
                'json'
            );
            ${'validate'.$key} = $this->validator->validate(${$key.'Dto'});

            if ( \count(${'validate'.$key}) > 0 ) {
                return new JsonResponse(
                    ${'validate'.$key},
                    Response::HTTP_BAD_REQUEST
                );
            }
        }

        $password = $userDto->getPlainPassword();
        $userDto = $this->userRepository->upgradePassword($userDto, $password);
        $reservationsDto->setVacanciesId($vacanciesDto);
        $reservationsDto->setUserId($userDto);
        $reservationDto = $this->calculator->count($reservationsDto);
        $vacanciesAvailable = $this->vacancies->checkIsVacanciesAvailable(
            $vacanciesDto,
            $this->getParameter('Vacancies')
        );

        if ($vacanciesAvailable === false) {
            return new JsonResponse(
                'No vacancies available.',
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $this->reservation->create($reservationDto);
        } catch (Exception $exception) {
            return new JsonResponse(
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse(
            'Reservation created succesfully.',
            Response::HTTP_CREATED
        );
    }

    /**
     * Delete a resource by its identifier.
     *
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function deleteAction(string $id): JsonResponse
    {
        $entity = $this->reservation->get($id);

        if (null === $entity) {
            return new JsonResponse(
                'Resource not found.',
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $this->reservation->delete($id);
        } catch (Exception $e) {
            return new JsonResponse(
                'Error occurred while trying to delete the resource.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse(
            null,
            Response::HTTP_NO_CONTENT
        );
    }
}
