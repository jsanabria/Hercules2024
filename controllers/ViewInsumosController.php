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

class ViewInsumosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ViewInsumosList[/{Nservicio:.*}]", [PermissionMiddleware::class], "list.view_insumos")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewInsumosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ViewInsumosAdd[/{Nservicio:.*}]", [PermissionMiddleware::class], "add.view_insumos")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewInsumosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ViewInsumosView[/{Nservicio:.*}]", [PermissionMiddleware::class], "view.view_insumos")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewInsumosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ViewInsumosEdit[/{Nservicio:.*}]", [PermissionMiddleware::class], "edit.view_insumos")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewInsumosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ViewInsumosDelete[/{Nservicio:.*}]", [PermissionMiddleware::class], "delete.view_insumos")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewInsumosDelete");
    }
}
