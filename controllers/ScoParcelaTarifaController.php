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

class ScoParcelaTarifaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaTarifaList[/{Nparcela_tarifa}]", [PermissionMiddleware::class], "list.sco_parcela_tarifa")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaTarifaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaTarifaAdd[/{Nparcela_tarifa}]", [PermissionMiddleware::class], "add.sco_parcela_tarifa")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaTarifaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaTarifaView[/{Nparcela_tarifa}]", [PermissionMiddleware::class], "view.sco_parcela_tarifa")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaTarifaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaTarifaEdit[/{Nparcela_tarifa}]", [PermissionMiddleware::class], "edit.sco_parcela_tarifa")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaTarifaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaTarifaDelete[/{Nparcela_tarifa}]", [PermissionMiddleware::class], "delete.sco_parcela_tarifa")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaTarifaDelete");
    }
}
