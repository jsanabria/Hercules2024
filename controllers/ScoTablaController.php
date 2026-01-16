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

class ScoTablaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoTablaList[/{Ntabla}]", [PermissionMiddleware::class], "list.sco_tabla")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTablaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoTablaAdd[/{Ntabla}]", [PermissionMiddleware::class], "add.sco_tabla")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTablaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoTablaView[/{Ntabla}]", [PermissionMiddleware::class], "view.sco_tabla")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTablaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoTablaEdit[/{Ntabla}]", [PermissionMiddleware::class], "edit.sco_tabla")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTablaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoTablaDelete[/{Ntabla}]", [PermissionMiddleware::class], "delete.sco_tabla")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTablaDelete");
    }
}
