<?php

namespace App\Functional\Tests\Controller;

use App\Tests\UserAuthentication;
use Symfony\Component\HttpFoundation\Response;
use DateTimeImmutable;

/**
 * Summary of ReservationsControllerTest
 */
class ReservationsControllerTests extends UserAuthentication
{
    /**
     * Summary of formData
     * @var 
     */
    private $formData;

    /**
     * Summary of client
     * @var 
     */
    private $client;

    /**
     * Summary of token
     * @var 
     */
    private $token;

    /**
     * Summary of setUp
     * @return void
     */
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->token = $this->generateToken();
        $this->formData = [
            'firstName' => 'firstName',
            'surname' => 'surname',
            'dateFrom' => '2023-09-21 00:00:00',
            'dateTo' => '2023-09-23 00:00:00'
        ];
    }

    /**
     * Summary of testGetReservations
     * @return void
     */
    public function testGetReservations()
    {
        $reservationId = 1;
        $url = sprintf('%s%s', '/v1/api/reservations/', $reservationId);
        $this->client->request('GET', $url, [], [], ['HTTP_AUTHORIZATION' => 'Bearer '. $this->token]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    /**
     * Summary of testGetReservationsWithNoExistId
     * @return void
     */
    public function testGetReservationsWithNoExistId()
    {
        $reservationId = 100;
        $url = sprintf('%s%s', '/v1/api/reservations/', $reservationId);
        $this->client->request('GET', $url, [], [], ['HTTP_AUTHORIZATION' => 'Bearer '. $this->token]);

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    /**
     * Summary of testGetListReservations
     * @return void
     */
    public function testGetListReservations()
    {
        $this->client->request('GET', '/v1/api/reservations', [], [], ['HTTP_AUTHORIZATION' => 'Bearer '. $this->token]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    /**
     * Summary of testCreateReservation
     * @return void
     */
    public function testCreateReservation()
    {
        $url = '/v1/api/reservations';
        $authorization = ['HTTP_AUTHORIZATION' => 'Bearer '. $this->token];
        $this->client->request('POST', $url, $this->formData, [], $authorization);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    /**
     * Summary of testCreateReservationWithBadData
     * @return void
     */
    public function testCreateReservationWithBadData()
    {
        $data = ['data' => 'invalid_data'];
        $url = '/v1/api/reservations';
        $authorization = ['HTTP_AUTHORIZATION' => 'Bearer '. $this->token];
        $this->client->request('POST', $url, $data, [], $authorization);

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    /**
     * Summary of testDeleteReservation
     * @return void
     */
    public function testDeleteReservation()
    {
        $reservationId = 1;
        $url = sprintf('%s%s', '/v1/api/reservations/', $reservationId);
        $this->client->request('DELETE', $url, [], [], ['HTTP_AUTHORIZATION' => 'Bearer '. $this->token]);

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    /**
     * Summary of testDeleteReservationWithNoExistId
     * @return void
     */
    public function testDeleteReservationWithNoExistId()
    {
        $reservationId = 100;
        $url = sprintf('%s%s', '/v1/api/reservations/', $reservationId);
        $this->client->request('DELETE', $url, [], [], ['HTTP_AUTHORIZATION' => 'Bearer '. $this->token]);

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }
}