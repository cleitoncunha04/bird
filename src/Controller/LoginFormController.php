<?php

namespace Cleitoncunha\Bird\Controller;

use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class LoginFormController implements RequestHandlerInterface
{
    public function __construct(
        private Engine $templates,
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (array_key_exists('logged', $_SESSION) && $_SESSION['logged']) {
            return new Response(302, ['Location' => '/']);
        } else {
            return new Response(status: 200, body: $this->templates->render('vw_login'));
        }
    }
}