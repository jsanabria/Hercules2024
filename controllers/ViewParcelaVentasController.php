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

class ViewParcelaVentasController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ViewParcelaVentasList[/{Nparcela_ventas}]", [PermissionMiddleware::class], "list.view_parcela_ventas")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewParcelaVentasList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ViewParcelaVentasView[/{Nparcela_ventas}]", [PermissionMiddleware::class], "view.view_parcela_ventas")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewParcelaVentasView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ViewParcelaVentasEdit[/{Nparcela_ventas}]", [PermissionMiddleware::class], "edit.view_parcela_ventas")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewParcelaVentasEdit");
    }
}
