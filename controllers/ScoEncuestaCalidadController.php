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

class ScoEncuestaCalidadController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoEncuestaCalidadList[/{Nencuesta_calidad}]", [PermissionMiddleware::class], "list.sco_encuesta_calidad")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEncuestaCalidadList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoEncuestaCalidadAdd[/{Nencuesta_calidad}]", [PermissionMiddleware::class], "add.sco_encuesta_calidad")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEncuestaCalidadAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoEncuestaCalidadView[/{Nencuesta_calidad}]", [PermissionMiddleware::class], "view.sco_encuesta_calidad")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEncuestaCalidadView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoEncuestaCalidadEdit[/{Nencuesta_calidad}]", [PermissionMiddleware::class], "edit.sco_encuesta_calidad")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEncuestaCalidadEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoEncuestaCalidadDelete[/{Nencuesta_calidad}]", [PermissionMiddleware::class], "delete.sco_encuesta_calidad")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEncuestaCalidadDelete");
    }
}
