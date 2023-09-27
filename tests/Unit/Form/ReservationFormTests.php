<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Form\ReservationFormType;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Summary of ReservationFormTests
 */
class ReservationFormTests extends WebTestCase
{
    /**
     * Summary of formFactory
     * @var 
     */
    private $formFactory;

    /**
     * Summary of formData
     * @var 
     */
    private $formData;

    /**
     * Summary of setUp
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->formFactory = static::createClient()->getContainer()->get('form.factory');

        $this->formData = [
            'firstName' => 'firstName',
            'surname' => 'surname',
            'dateFrom' => new DateTimeImmutable('2023-09-21 00:00:00'),
            'dateTo' => new DateTimeImmutable('2023-09-23 00:00:00')
        ];
    }

    /**
     * Summary of testSubmitValidData
     * @return void
     */
    public function testSubmitValidData(): void
    {
        $form = $this->formFactory->create(ReservationFormType::class, null, []);
        $form->submit($this->formData);
   
        $this->assertTrue($form->isSynchronized());
    }

    /**
     * Summary of testValidators
     * @return void
     */
    public function testValidators()
    {
        $requestData = ['data' => 'invalid_data'];
        $form = $this->formFactory->create(ReservationFormType::class, null, []);
        $form->submit($requestData);

        $this->assertFalse($form->isValid());
        $this->assertCount(4, $form->getErrors(true));
    }

    /**
     * Summary of testFormData
     * @return void
     */
    public function testFormData()
    {
        $form = $this->formFactory->create(ReservationFormType::class, $this->formData, []);
        $form->submit($this->formData);
        $formData = $form->getData();

        $this->assertEquals('firstName', $formData['firstName']);
        $this->assertEquals('surname', $formData['surname']);
        $this->assertEquals(new DateTimeImmutable('2023-09-21 00:00:00'), $formData['dateFrom']);
        $this->assertEquals(new DateTimeImmutable('2023-09-23 00:00:00'), $formData['dateTo']);
    }
}