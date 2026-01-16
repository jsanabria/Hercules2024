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

class ScoSeguimientoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoSeguimientoList[/{Nseguimiento}]", [PermissionMiddleware::class], "list.sco_seguimiento")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoSeguimientoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoSeguimientoAdd[/{Nseguimiento}]", [PermissionMiddleware::class], "add.sco_seguimiento")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoSeguimientoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoSeguimientoView[/{Nseguimiento}]", [PermissionMiddleware::class], "view.sco_seguimiento")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoSeguimientoView");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoSeguimientoDelete[/{Nseguimiento}]", [PermissionMiddleware::class], "delete.sco_seguimiento")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoSeguimientoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoSeguimientoPreview", [PermissionMiddleware::class], "preview.sco_seguimiento")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoSeguimientoPreview", null, false);
    }
}
