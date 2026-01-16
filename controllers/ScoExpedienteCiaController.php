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

class ScoExpedienteCiaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteCiaList[/{Nexpediente_cia}]", [PermissionMiddleware::class], "list.sco_expediente_cia")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteCiaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteCiaAdd[/{Nexpediente_cia}]", [PermissionMiddleware::class], "add.sco_expediente_cia")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteCiaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteCiaView[/{Nexpediente_cia}]", [PermissionMiddleware::class], "view.sco_expediente_cia")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteCiaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteCiaEdit[/{Nexpediente_cia}]", [PermissionMiddleware::class], "edit.sco_expediente_cia")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteCiaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteCiaDelete[/{Nexpediente_cia}]", [PermissionMiddleware::class], "delete.sco_expediente_cia")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteCiaDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoExpedienteCiaPreview", [PermissionMiddleware::class], "preview.sco_expediente_cia")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteCiaPreview", null, false);
    }
}
