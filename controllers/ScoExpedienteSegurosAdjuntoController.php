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

class ScoExpedienteSegurosAdjuntoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteSegurosAdjuntoList[/{Nexpediente_seguros_adjunto}]", [PermissionMiddleware::class], "list.sco_expediente_seguros_adjunto")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteSegurosAdjuntoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteSegurosAdjuntoAdd[/{Nexpediente_seguros_adjunto}]", [PermissionMiddleware::class], "add.sco_expediente_seguros_adjunto")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteSegurosAdjuntoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteSegurosAdjuntoView[/{Nexpediente_seguros_adjunto}]", [PermissionMiddleware::class], "view.sco_expediente_seguros_adjunto")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteSegurosAdjuntoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteSegurosAdjuntoEdit[/{Nexpediente_seguros_adjunto}]", [PermissionMiddleware::class], "edit.sco_expediente_seguros_adjunto")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteSegurosAdjuntoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteSegurosAdjuntoDelete[/{Nexpediente_seguros_adjunto}]", [PermissionMiddleware::class], "delete.sco_expediente_seguros_adjunto")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteSegurosAdjuntoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoExpedienteSegurosAdjuntoPreview", [PermissionMiddleware::class], "preview.sco_expediente_seguros_adjunto")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteSegurosAdjuntoPreview", null, false);
    }
}
