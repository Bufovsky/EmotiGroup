<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\User;
use App\Repository\UserRepository;

/**
 * Summary of RegistrationController
 */
#[Route('/api', name: 'api_')]
class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register', methods: ['post'])]
    /**
     * Summary of index
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface $passwordHasher
     * @param \App\Repository\UserRepository $userRepository
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     * @param \Symfony\Component\Serializer\SerializerInterface $serializer
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository,
        ValidatorInterface $validator,
        SerializerInterface $serializer
    ): JsonResponse {
        $requestJson = json_decode($request->getContent());
        $requestSerialized = $serializer->serialize($requestJson, 'json');
        $registrationDto = $serializer->deserialize(
            $requestSerialized,
            User::class,
            'json'
        );
        $errors = $validator->validate($registrationDto);

        if (\count($errors) > 0) {
            return new JsonResponse(
                "$errors",
                Response::HTTP_BAD_REQUEST
            );
        }

        $hashedPassword = $passwordHasher->hashPassword(
            new User,
            $requestJson->password
        );
        $registrationDto->setPassword($hashedPassword);
        $userRepository->save($registrationDto, true);

        return new JsonResponse(
            'User registered successfully.',
            Response::HTTP_CREATED
        );
    }
}
