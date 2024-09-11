<?php

namespace Cleitoncunha\Bird\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Nyholm\Psr7\Stream;

class Error404Controller implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Mensagem simples de erro
        $body = "404 - Página não encontrada";

        // Criar um stream com o conteúdo do corpo
        $bodyStream = Stream::create($body);

        return new Response(
            status: 404, // Define o código de status como 404
            headers: ['Content-Type' => 'text/plain'], // O cabeçalho de resposta para texto
            body: $bodyStream // O corpo da resposta como stream
        );
    }
}
