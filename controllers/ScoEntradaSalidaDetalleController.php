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

class ScoEntradaSalidaDetalleController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoEntradaSalidaDetalleList[/{Nentrada_salida_detalle}]", [PermissionMiddleware::class], "list.sco_entrada_salida_detalle")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEntradaSalidaDetalleList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoEntradaSalidaDetalleAdd[/{Nentrada_salida_detalle}]", [PermissionMiddleware::class], "add.sco_entrada_salida_detalle")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEntradaSalidaDetalleAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoEntradaSalidaDetalleView[/{Nentrada_salida_detalle}]", [PermissionMiddleware::class], "view.sco_entrada_salida_detalle")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEntradaSalidaDetalleView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoEntradaSalidaDetalleEdit[/{Nentrada_salida_detalle}]", [PermissionMiddleware::class], "edit.sco_entrada_salida_detalle")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEntradaSalidaDetalleEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoEntradaSalidaDetalleDelete[/{Nentrada_salida_detalle}]", [PermissionMiddleware::class], "delete.sco_entrada_salida_detalle")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEntradaSalidaDetalleDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoEntradaSalidaDetallePreview", [PermissionMiddleware::class], "preview.sco_entrada_salida_detalle")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEntradaSalidaDetallePreview", null, false);
    }
}
