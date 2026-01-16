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

class ScoLocalidadController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoLocalidadList[/{Nlocalidad}]", [PermissionMiddleware::class], "list.sco_localidad")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLocalidadList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoLocalidadAdd[/{Nlocalidad}]", [PermissionMiddleware::class], "add.sco_localidad")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLocalidadAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoLocalidadView[/{Nlocalidad}]", [PermissionMiddleware::class], "view.sco_localidad")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLocalidadView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoLocalidadEdit[/{Nlocalidad}]", [PermissionMiddleware::class], "edit.sco_localidad")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLocalidadEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoLocalidadDelete[/{Nlocalidad}]", [PermissionMiddleware::class], "delete.sco_localidad")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLocalidadDelete");
    }
}
