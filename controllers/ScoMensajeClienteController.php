<?php

namespace PHPMaker2024\hercules;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\hercules\Attributes\Delete;
use PHPMaker2024\hercules\Attributes\Get;
use PHPMaker2024\hercules\Attributes\Map;
use PHPMaker2024\hercules\Attributes\Options;
use PHPMaker2024\hercules\Attributes\Patch;
use PHPMaker2024\hercules\Attributes\Post;
use PHPMaker2024\hercules\Attributes\Put;

class ScoMensajeClienteController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoMensajeClienteList[/{Nmensaje_cliente}]", [PermissionMiddleware::class], "list.sco_mensaje_cliente")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMensajeClienteList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoMensajeClienteView[/{Nmensaje_cliente}]", [PermissionMiddleware::class], "view.sco_mensaje_cliente")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMensajeClienteView");
    }
}
