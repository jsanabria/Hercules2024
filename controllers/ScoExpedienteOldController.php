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

class ScoExpedienteOldController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteOldList[/{Nexpediente}]", [PermissionMiddleware::class], "list.sco_expediente_old")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteOldList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteOldAdd[/{Nexpediente}]", [PermissionMiddleware::class], "add.sco_expediente_old")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteOldAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteOldView[/{Nexpediente}]", [PermissionMiddleware::class], "view.sco_expediente_old")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteOldView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteOldEdit[/{Nexpediente}]", [PermissionMiddleware::class], "edit.sco_expediente_old")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteOldEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteOldDelete[/{Nexpediente}]", [PermissionMiddleware::class], "delete.sco_expediente_old")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteOldDelete");
    }
}
