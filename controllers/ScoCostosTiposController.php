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

class ScoCostosTiposController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTiposList[/{Ncostos_tipos:.*}]", [PermissionMiddleware::class], "list.sco_costos_tipos")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTiposList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTiposAdd[/{Ncostos_tipos:.*}]", [PermissionMiddleware::class], "add.sco_costos_tipos")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTiposAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTiposView[/{Ncostos_tipos:.*}]", [PermissionMiddleware::class], "view.sco_costos_tipos")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTiposView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTiposEdit[/{Ncostos_tipos:.*}]", [PermissionMiddleware::class], "edit.sco_costos_tipos")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTiposEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTiposDelete[/{Ncostos_tipos:.*}]", [PermissionMiddleware::class], "delete.sco_costos_tipos")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTiposDelete");
    }
}
