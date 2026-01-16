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

class ScoReclamoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoList[/{Nreclamo}]", [PermissionMiddleware::class], "list.sco_reclamo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoAdd[/{Nreclamo}]", [PermissionMiddleware::class], "add.sco_reclamo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoView[/{Nreclamo}]", [PermissionMiddleware::class], "view.sco_reclamo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoEdit[/{Nreclamo}]", [PermissionMiddleware::class], "edit.sco_reclamo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoDelete[/{Nreclamo}]", [PermissionMiddleware::class], "delete.sco_reclamo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoDelete");
    }
}
