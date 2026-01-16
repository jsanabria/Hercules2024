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

class ScoNotaOrdenCompraController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoNotaOrdenCompraList[/{Nnota_orden_compra}]", [PermissionMiddleware::class], "list.sco_nota_orden_compra")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaOrdenCompraList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoNotaOrdenCompraAdd[/{Nnota_orden_compra}]", [PermissionMiddleware::class], "add.sco_nota_orden_compra")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaOrdenCompraAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoNotaOrdenCompraView[/{Nnota_orden_compra}]", [PermissionMiddleware::class], "view.sco_nota_orden_compra")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaOrdenCompraView");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoNotaOrdenCompraPreview", [PermissionMiddleware::class], "preview.sco_nota_orden_compra")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaOrdenCompraPreview", null, false);
    }
}
