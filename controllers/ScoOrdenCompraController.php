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

class ScoOrdenCompraController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenCompraList[/{Norden_compra}]", [PermissionMiddleware::class], "list.sco_orden_compra")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenCompraList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenCompraAdd[/{Norden_compra}]", [PermissionMiddleware::class], "add.sco_orden_compra")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenCompraAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenCompraView[/{Norden_compra}]", [PermissionMiddleware::class], "view.sco_orden_compra")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenCompraView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenCompraEdit[/{Norden_compra}]", [PermissionMiddleware::class], "edit.sco_orden_compra")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenCompraEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenCompraDelete[/{Norden_compra}]", [PermissionMiddleware::class], "delete.sco_orden_compra")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenCompraDelete");
    }
}
