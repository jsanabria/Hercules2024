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

class ScoOrdenCompraDetalleController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenCompraDetalleList[/{Norden_compra_detalle}]", [PermissionMiddleware::class], "list.sco_orden_compra_detalle")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenCompraDetalleList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenCompraDetalleAdd[/{Norden_compra_detalle}]", [PermissionMiddleware::class], "add.sco_orden_compra_detalle")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenCompraDetalleAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenCompraDetalleView[/{Norden_compra_detalle}]", [PermissionMiddleware::class], "view.sco_orden_compra_detalle")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenCompraDetalleView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenCompraDetalleEdit[/{Norden_compra_detalle}]", [PermissionMiddleware::class], "edit.sco_orden_compra_detalle")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenCompraDetalleEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenCompraDetalleDelete[/{Norden_compra_detalle}]", [PermissionMiddleware::class], "delete.sco_orden_compra_detalle")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenCompraDetalleDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoOrdenCompraDetallePreview", [PermissionMiddleware::class], "preview.sco_orden_compra_detalle")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenCompraDetallePreview", null, false);
    }
}
