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

class ScoParametroController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoParametroList[/{Nparametro}]", [PermissionMiddleware::class], "list.sco_parametro")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParametroList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoParametroAdd[/{Nparametro}]", [PermissionMiddleware::class], "add.sco_parametro")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParametroAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoParametroView[/{Nparametro}]", [PermissionMiddleware::class], "view.sco_parametro")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParametroView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoParametroEdit[/{Nparametro}]", [PermissionMiddleware::class], "edit.sco_parametro")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParametroEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoParametroDelete[/{Nparametro}]", [PermissionMiddleware::class], "delete.sco_parametro")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParametroDelete");
    }
}
