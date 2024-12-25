<?php

namespace Cleitoncunha\Bird\Controller;

use Cleitoncunha\Bird\Helper\ErrorMessageTrait;
use Cleitoncunha\Bird\Model\Entity\User;
use Cleitoncunha\Bird\Model\Repository\UserRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function sleep;

readonly class LoginController implements RequestHandlerInterface
{
    use ErrorMessageTrait;

    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getParsedBody();

        $email = filter_var($queryParams['email'], FILTER_SANITIZE_EMAIL);

        $password = filter_var($queryParams['password']);

        $user = $this->userRepository->findByEmail($email)[0];

        if (password_verify($password, $user->password ?? '')) {
            if (password_needs_rehash($user->password, PASSWORD_ARGON2ID)) {
                $newPasswordUser = new User(
                    $user->id,
                    $user->username,
                    $user->email,
                    password_hash($user->password, PASSWORD_ARGON2ID),
                    $user->level
                );

                $this->userRepository->save($newPasswordUser);
            }

            $_SESSION['logged'] = true;
            $_SESSION['username'] = $user->username;
            $_SESSION['user_level'] = $user->level == 1 ? 'Docente' : 'Administrador';

            sleep(1);

            return new Response(302, ['Location' => '/']);
        }

        $this->addErrorMessage('E-mail ou senha inválidos');

        return new Response(302, ['Location' => '/login']);
    }
}