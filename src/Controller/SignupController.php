<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Helper\ErrorMessageTrait;
use Cleitoncunha\Bird\Model\Entity\User;
use Cleitoncunha\Bird\Model\Repository\UserRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function password_hash;

readonly class SignupController implements RequestHandlerInterface
{
    use ErrorMessageTrait;

    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    private function redirectWithError(string $errorMessage): ResponseInterface
    {
        $this->addErrorMessage($errorMessage);
        return new Response(302, ['Location' => '/signup']);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Obtém o conteúdo do POST
        $queryParams = $request->getParsedBody();

        $username = htmlspecialchars($queryParams['username'], ENT_QUOTES, 'UTF-8');
        $email = filter_var($queryParams['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($queryParams['password']);
        $confirmPassword = filter_var($queryParams['confirmPassword']);

        if ($confirmPassword !== $password) {
            return $this->redirectWithError("The passwords do not match");
        }

        if (!$this->userRepository->isValidEmail($email)) {
            return $this->redirectWithError("Email doesn't valid");
        }

        if ($this->userRepository->isUserAlreadyRegistered($email)) {
            return $this->redirectWithError("Email already registered");
        }

        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

        $newUser = new User(
            id: null,
            username: $username,
            email: $email,
            password: $hashedPassword,
            level: 1
        );

        if (!$this->userRepository->save($newUser)) {
            return $this->redirectWithError("Error creating user");
        }

        return new Response(302, ['Location' => '/login']);
    }
}
