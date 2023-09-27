<?php

namespace App\Unit\Tests\Controller;

use App\Entity\User;
use App\Controller\ReservationsController;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Summary of ReservationsTests
 */
class ReservationsControllerTests extends KernelTestCase
{
    /**
     * Summary of formData
     * @var array
     */
    private array $formData;

    /**
     * Summary of container
     * @var object
     */
    private object $container;

    /**
     * Summary of setUp
     * @return void
     */
    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();
        $this->container = $container->get(ReservationsController::class);
        $this->formData = [
            'firstName' => 'firstName',
            'surname' => 'surname',
            'dateFrom' => new DateTimeImmutable('2023-09-21 00:00:00'),
            'dateTo' => new DateTimeImmutable('2023-09-23 00:00:00')
        ];
    }

    /**
     * Summary of testGetAction
     * @return void
     */
    public function testGetAction()
    {
        $reservationId = 1;
        $response = $this->container->getAction($reservationId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }


    /**
     * Summary of testGetActionWithNoExistId
     * @return void
     */
    public function testGetActionWithNoExistId()
    {
        $reservationId = 100;
        $response = $this->container->getAction($reservationId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }

    /**
     * Summary of testGetListAction
     * @return void
     */
    public function testGetListAction()
    {
        $request = Request::create('/test/api/reservations', 'GET');
        $response = $this->container->getListAction($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    /**
     * Summary of testCreateAction
     * @return void
     */
    public function testCreateAction()
    {
        $request = Request::create('/v1/api/reservations', 'POST', $this->formData);
        $response = $this->container->createAction($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
    }

    /**
     * Summary of testCreateActionWithInvalidData
     * @return void
     */
    public function testCreateActionWithInvalidData()
    {
        $requestData = ['data' => 'invalid_data'];
        $request = Request::create('/v1/api/reservations', 'POST', $requestData);
        $response = $this->container->createAction($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
    
    /**
     * Summary of testDeleteAction
     * @return void
     */
    public function testDeleteAction()
    {
        $reservationId = 1;
        $response = $this->container->deleteAction($reservationId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    /**
     * Summary of testDeleteAction
     * @return void
     */
    public function testDeleteActionWithNoExistId()
    {
        $reservationId = 100;
        $response = $this->container->deleteAction($reservationId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
}