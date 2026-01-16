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

class ScoParcelaVentasController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaVentasList[/{Nparcela_ventas}]", [PermissionMiddleware::class], "list.sco_parcela_ventas")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaVentasList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaVentasAdd[/{Nparcela_ventas}]", [PermissionMiddleware::class], "add.sco_parcela_ventas")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaVentasAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaVentasView[/{Nparcela_ventas}]", [PermissionMiddleware::class], "view.sco_parcela_ventas")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaVentasView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaVentasEdit[/{Nparcela_ventas}]", [PermissionMiddleware::class], "edit.sco_parcela_ventas")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaVentasEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaVentasDelete[/{Nparcela_ventas}]", [PermissionMiddleware::class], "delete.sco_parcela_ventas")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaVentasDelete");
    }
}
