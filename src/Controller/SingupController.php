<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Helper\ErrorMessageTrait;
use Cleitoncunha\Bird\Model\Entity\User;
use Cleitoncunha\Bird\Model\Repository\UserRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class SingupController implements RequestHandlerInterface
{
    use ErrorMessageTrait;

    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        //retorna o conteudo do POST
        $queryParams = $request->getParsedBody();

        $username = htmlspecialchars($queryParams['username'], ENT_QUOTES, 'UTF-8');

        $email = filter_var($queryParams['email'], FILTER_VALIDATE_EMAIL);

        $password = filter_var($queryParams['password']);

        $confirmPassword = filter_var($queryParams['confirmPassword']);

        if ($confirmPassword !== $password) {
            $this->addErrorMessage("The passwords do not match");

            return new Response(302, ['Location' => '/singup']);
        } else {
            $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

            $newUser = new User(
                id: null,
                username: $username,
                email: $email,
                password: $hashedPassword,
                level: 1
            );

            if ($this->userRepository->save($newUser)) {
                $_SESSION['logged'] = true;

                return new Response(201, ['Location' => '/login']);
            } else {
                $this->addErrorMessage("Error creating user");

                return new Response(302, ['Location' => '/singup']);
            }
        }
    }
}