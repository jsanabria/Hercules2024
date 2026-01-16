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

class ScoCostosTarifaDetalleController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTarifaDetalleList[/{Ncostos_tarifa_detalle}]", [PermissionMiddleware::class], "list.sco_costos_tarifa_detalle")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTarifaDetalleList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTarifaDetalleAdd[/{Ncostos_tarifa_detalle}]", [PermissionMiddleware::class], "add.sco_costos_tarifa_detalle")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTarifaDetalleAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTarifaDetalleView[/{Ncostos_tarifa_detalle}]", [PermissionMiddleware::class], "view.sco_costos_tarifa_detalle")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTarifaDetalleView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTarifaDetalleEdit[/{Ncostos_tarifa_detalle}]", [PermissionMiddleware::class], "edit.sco_costos_tarifa_detalle")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTarifaDetalleEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoCostosTarifaDetalleDelete[/{Ncostos_tarifa_detalle}]", [PermissionMiddleware::class], "delete.sco_costos_tarifa_detalle")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTarifaDetalleDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoCostosTarifaDetallePreview", [PermissionMiddleware::class], "preview.sco_costos_tarifa_detalle")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCostosTarifaDetallePreview", null, false);
    }
}
