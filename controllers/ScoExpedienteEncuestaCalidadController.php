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

class ScoExpedienteEncuestaCalidadController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteEncuestaCalidadList[/{Nexpediente_encuesta_calidad}]", [PermissionMiddleware::class], "list.sco_expediente_encuesta_calidad")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteEncuestaCalidadList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteEncuestaCalidadAdd[/{Nexpediente_encuesta_calidad}]", [PermissionMiddleware::class], "add.sco_expediente_encuesta_calidad")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteEncuestaCalidadAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteEncuestaCalidadView[/{Nexpediente_encuesta_calidad}]", [PermissionMiddleware::class], "view.sco_expediente_encuesta_calidad")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteEncuestaCalidadView");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoExpedienteEncuestaCalidadPreview", [PermissionMiddleware::class], "preview.sco_expediente_encuesta_calidad")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteEncuestaCalidadPreview", null, false);
    }
}
