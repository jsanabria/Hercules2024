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

class ScoFlotaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaList[/{Nflota}]", [PermissionMiddleware::class], "list.sco_flota")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaAdd[/{Nflota}]", [PermissionMiddleware::class], "add.sco_flota")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaView[/{Nflota}]", [PermissionMiddleware::class], "view.sco_flota")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaEdit[/{Nflota}]", [PermissionMiddleware::class], "edit.sco_flota")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoFlotaDelete[/{Nflota}]", [PermissionMiddleware::class], "delete.sco_flota")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoFlotaDelete");
    }
}
