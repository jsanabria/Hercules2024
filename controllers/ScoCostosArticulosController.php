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

class ScoCostosArticulosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosArticulosList[/{Ncostos_articulo:.*}]", [PermissionMiddleware::class], "list.sco_costos_articulos")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosArticulosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosArticulosAdd[/{Ncostos_articulo:.*}]", [PermissionMiddleware::class], "add.sco_costos_articulos")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosArticulosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosArticulosView[/{Ncostos_articulo:.*}]", [PermissionMiddleware::class], "view.sco_costos_articulos")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosArticulosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosArticulosEdit[/{Ncostos_articulo:.*}]", [PermissionMiddleware::class], "edit.sco_costos_articulos")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosArticulosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosArticulosDelete[/{Ncostos_articulo:.*}]", [PermissionMiddleware::class], "delete.sco_costos_articulos")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosArticulosDelete");
    }
}
