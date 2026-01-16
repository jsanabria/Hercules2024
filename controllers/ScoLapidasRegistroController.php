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

class ScoLapidasRegistroController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasRegistroList[/{Nlapidas_registro}]", [PermissionMiddleware::class], "list.sco_lapidas_registro")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasRegistroList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasRegistroAdd[/{Nlapidas_registro}]", [PermissionMiddleware::class], "add.sco_lapidas_registro")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasRegistroAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasRegistroView[/{Nlapidas_registro}]", [PermissionMiddleware::class], "view.sco_lapidas_registro")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasRegistroView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasRegistroEdit[/{Nlapidas_registro}]", [PermissionMiddleware::class], "edit.sco_lapidas_registro")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasRegistroEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasRegistroDelete[/{Nlapidas_registro}]", [PermissionMiddleware::class], "delete.sco_lapidas_registro")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasRegistroDelete");
    }
}
