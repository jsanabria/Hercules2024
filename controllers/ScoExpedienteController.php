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

class ScoExpedienteController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteList[/{Nexpediente}]", [PermissionMiddleware::class], "list.sco_expediente")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteAdd[/{Nexpediente}]", [PermissionMiddleware::class], "add.sco_expediente")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteView[/{Nexpediente}]", [PermissionMiddleware::class], "view.sco_expediente")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteEdit[/{Nexpediente}]", [PermissionMiddleware::class], "edit.sco_expediente")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteDelete[/{Nexpediente}]", [PermissionMiddleware::class], "delete.sco_expediente")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteDelete");
    }
}
