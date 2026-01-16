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

class ScoFlotaIncidenciaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaIncidenciaList[/{Nflota_incidencia}]", [PermissionMiddleware::class], "list.sco_flota_incidencia")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaIncidenciaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaIncidenciaAdd[/{Nflota_incidencia}]", [PermissionMiddleware::class], "add.sco_flota_incidencia")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaIncidenciaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaIncidenciaView[/{Nflota_incidencia}]", [PermissionMiddleware::class], "view.sco_flota_incidencia")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaIncidenciaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaIncidenciaEdit[/{Nflota_incidencia}]", [PermissionMiddleware::class], "edit.sco_flota_incidencia")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaIncidenciaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaIncidenciaDelete[/{Nflota_incidencia}]", [PermissionMiddleware::class], "delete.sco_flota_incidencia")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaIncidenciaDelete");
    }
}
