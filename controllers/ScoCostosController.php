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

class ScoCostosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosList[/{Ncostos}]", [PermissionMiddleware::class], "list.sco_costos")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosAdd[/{Ncostos}]", [PermissionMiddleware::class], "add.sco_costos")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosView[/{Ncostos}]", [PermissionMiddleware::class], "view.sco_costos")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosEdit[/{Ncostos}]", [PermissionMiddleware::class], "edit.sco_costos")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosDelete[/{Ncostos}]", [PermissionMiddleware::class], "delete.sco_costos")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosDelete");
    }
}
