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

class ScoParcelaVentasNotaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaVentasNotaList[/{Nparcela_ventas_nota}]", [PermissionMiddleware::class], "list.sco_parcela_ventas_nota")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaVentasNotaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaVentasNotaAdd[/{Nparcela_ventas_nota}]", [PermissionMiddleware::class], "add.sco_parcela_ventas_nota")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaVentasNotaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaVentasNotaView[/{Nparcela_ventas_nota}]", [PermissionMiddleware::class], "view.sco_parcela_ventas_nota")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaVentasNotaView");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoParcelaVentasNotaPreview", [PermissionMiddleware::class], "preview.sco_parcela_ventas_nota")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaVentasNotaPreview", null, false);
    }
}
