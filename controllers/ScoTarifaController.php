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

class ScoTarifaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoTarifaList[/{Ntarifa}]", [PermissionMiddleware::class], "list.sco_tarifa")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTarifaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoTarifaAdd[/{Ntarifa}]", [PermissionMiddleware::class], "add.sco_tarifa")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTarifaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoTarifaView[/{Ntarifa}]", [PermissionMiddleware::class], "view.sco_tarifa")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTarifaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoTarifaEdit[/{Ntarifa}]", [PermissionMiddleware::class], "edit.sco_tarifa")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTarifaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoTarifaDelete[/{Ntarifa}]", [PermissionMiddleware::class], "delete.sco_tarifa")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTarifaDelete");
    }
}
