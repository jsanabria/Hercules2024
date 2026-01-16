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

class ScoTipoFlotaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoTipoFlotaList[/{Ntipo_flota}]", [PermissionMiddleware::class], "list.sco_tipo_flota")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTipoFlotaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoTipoFlotaAdd[/{Ntipo_flota}]", [PermissionMiddleware::class], "add.sco_tipo_flota")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTipoFlotaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoTipoFlotaView[/{Ntipo_flota}]", [PermissionMiddleware::class], "view.sco_tipo_flota")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTipoFlotaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoTipoFlotaEdit[/{Ntipo_flota}]", [PermissionMiddleware::class], "edit.sco_tipo_flota")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTipoFlotaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoTipoFlotaDelete[/{Ntipo_flota}]", [PermissionMiddleware::class], "delete.sco_tipo_flota")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTipoFlotaDelete");
    }
}
