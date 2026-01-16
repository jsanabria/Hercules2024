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

class ScoOrdenSalidaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenSalidaList[/{Norden_salida}]", [PermissionMiddleware::class], "list.sco_orden_salida")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenSalidaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenSalidaAdd[/{Norden_salida}]", [PermissionMiddleware::class], "add.sco_orden_salida")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenSalidaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenSalidaView[/{Norden_salida}]", [PermissionMiddleware::class], "view.sco_orden_salida")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenSalidaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenSalidaEdit[/{Norden_salida}]", [PermissionMiddleware::class], "edit.sco_orden_salida")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenSalidaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenSalidaDelete[/{Norden_salida}]", [PermissionMiddleware::class], "delete.sco_orden_salida")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenSalidaDelete");
    }
}
