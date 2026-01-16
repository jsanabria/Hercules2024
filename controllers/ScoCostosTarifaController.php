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

class ScoCostosTarifaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTarifaList[/{Ncostos_tarifa}]", [PermissionMiddleware::class], "list.sco_costos_tarifa")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTarifaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTarifaAdd[/{Ncostos_tarifa}]", [PermissionMiddleware::class], "add.sco_costos_tarifa")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTarifaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTarifaView[/{Ncostos_tarifa}]", [PermissionMiddleware::class], "view.sco_costos_tarifa")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTarifaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTarifaEdit[/{Ncostos_tarifa}]", [PermissionMiddleware::class], "edit.sco_costos_tarifa")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTarifaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTarifaDelete[/{Ncostos_tarifa}]", [PermissionMiddleware::class], "delete.sco_costos_tarifa")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTarifaDelete");
    }
}
