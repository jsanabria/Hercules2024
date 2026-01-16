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

class ScoModeloController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoModeloList[/{Nmodelo}]", [PermissionMiddleware::class], "list.sco_modelo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoModeloList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoModeloAdd[/{Nmodelo}]", [PermissionMiddleware::class], "add.sco_modelo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoModeloAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoModeloView[/{Nmodelo}]", [PermissionMiddleware::class], "view.sco_modelo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoModeloView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoModeloEdit[/{Nmodelo}]", [PermissionMiddleware::class], "edit.sco_modelo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoModeloEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoModeloDelete[/{Nmodelo}]", [PermissionMiddleware::class], "delete.sco_modelo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoModeloDelete");
    }
}
