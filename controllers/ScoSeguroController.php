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

class ScoSeguroController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoSeguroList[/{Nseguro}]", [PermissionMiddleware::class], "list.sco_seguro")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoSeguroList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoSeguroAdd[/{Nseguro}]", [PermissionMiddleware::class], "add.sco_seguro")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoSeguroAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoSeguroView[/{Nseguro}]", [PermissionMiddleware::class], "view.sco_seguro")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoSeguroView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoSeguroEdit[/{Nseguro}]", [PermissionMiddleware::class], "edit.sco_seguro")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoSeguroEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoSeguroDelete[/{Nseguro}]", [PermissionMiddleware::class], "delete.sco_seguro")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoSeguroDelete");
    }
}
