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

class ScoArticuloController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoArticuloList[/{Narticulo}]", [PermissionMiddleware::class], "list.sco_articulo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoArticuloList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoArticuloAdd[/{Narticulo}]", [PermissionMiddleware::class], "add.sco_articulo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoArticuloAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoArticuloView[/{Narticulo}]", [PermissionMiddleware::class], "view.sco_articulo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoArticuloView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoArticuloEdit[/{Narticulo}]", [PermissionMiddleware::class], "edit.sco_articulo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoArticuloEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoArticuloDelete[/{Narticulo}]", [PermissionMiddleware::class], "delete.sco_articulo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoArticuloDelete");
    }
}
