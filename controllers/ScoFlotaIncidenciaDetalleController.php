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

class ScoFlotaIncidenciaDetalleController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaIncidenciaDetalleList[/{Nflota_incidencia_detalle}]", [PermissionMiddleware::class], "list.sco_flota_incidencia_detalle")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaIncidenciaDetalleList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaIncidenciaDetalleAdd[/{Nflota_incidencia_detalle}]", [PermissionMiddleware::class], "add.sco_flota_incidencia_detalle")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaIncidenciaDetalleAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaIncidenciaDetalleView[/{Nflota_incidencia_detalle}]", [PermissionMiddleware::class], "view.sco_flota_incidencia_detalle")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaIncidenciaDetalleView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaIncidenciaDetalleEdit[/{Nflota_incidencia_detalle}]", [PermissionMiddleware::class], "edit.sco_flota_incidencia_detalle")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaIncidenciaDetalleEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaIncidenciaDetalleDelete[/{Nflota_incidencia_detalle}]", [PermissionMiddleware::class], "delete.sco_flota_incidencia_detalle")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaIncidenciaDetalleDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoFlotaIncidenciaDetallePreview", [PermissionMiddleware::class], "preview.sco_flota_incidencia_detalle")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaIncidenciaDetallePreview", null, false);
    }
}
