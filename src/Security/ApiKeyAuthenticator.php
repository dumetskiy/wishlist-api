<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Response\JsonResponseCreator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiKeyAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityManagerInterface
     */
    private $apiKeyQueryParamName;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string $apiKeyQueryParamName
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        string $apiKeyQueryParamName
    ) {
        $this->entityManager = $entityManager;
        $this->apiKeyQueryParamName = $apiKeyQueryParamName;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request): bool
    {
        return $request->headers->has($this->apiKeyQueryParamName);
    }

    /**
     * @param Request $request
     *
     * @return string|null
     */
    public function getCredentials(Request $request): ?string
    {
        return $request->headers->get($this->apiKeyQueryParamName);
    }

    /**
     * @param string|null $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return User|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?User
    {
        if (!$credentials) {
            return null;
        }

        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['apiKey' => $credentials]);
    }

    /**
     * @param string|null $credentials
     * @param UserInterface $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     *
     * @return null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        return null;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return JsonResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return JsonResponseCreator::createErrorJsonResponse(
            'Authentication failed',
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     *
     * @return JsonResponse
     */
    public function start(Request $request, AuthenticationException $authException = null): JsonResponse
    {
        return JsonResponseCreator::createErrorJsonResponse(
            'No authentication data provided',
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * @return bool
     */
    public function supportsRememberMe(): bool
    {
        return false;
    }
}
