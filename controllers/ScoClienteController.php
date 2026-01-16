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

class ScoClienteController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoClienteList[/{Ncliente}]", [PermissionMiddleware::class], "list.sco_cliente")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoClienteList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoClienteAdd[/{Ncliente}]", [PermissionMiddleware::class], "add.sco_cliente")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoClienteAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoClienteView[/{Ncliente}]", [PermissionMiddleware::class], "view.sco_cliente")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoClienteView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoClienteEdit[/{Ncliente}]", [PermissionMiddleware::class], "edit.sco_cliente")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoClienteEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoClienteDelete[/{Ncliente}]", [PermissionMiddleware::class], "delete.sco_cliente")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoClienteDelete");
    }
}
