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

class ViewCapillasController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ViewCapillasList[/{Nservicio:.*}]", [PermissionMiddleware::class], "list.view_capillas")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewCapillasList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ViewCapillasAdd[/{Nservicio:.*}]", [PermissionMiddleware::class], "add.view_capillas")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewCapillasAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ViewCapillasView[/{Nservicio:.*}]", [PermissionMiddleware::class], "view.view_capillas")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewCapillasView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ViewCapillasEdit[/{Nservicio:.*}]", [PermissionMiddleware::class], "edit.view_capillas")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewCapillasEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ViewCapillasDelete[/{Nservicio:.*}]", [PermissionMiddleware::class], "delete.view_capillas")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewCapillasDelete");
    }
}
