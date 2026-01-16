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

class ScoProveedorController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoProveedorList[/{Nproveedor}]", [PermissionMiddleware::class], "list.sco_proveedor")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoProveedorList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoProveedorAdd[/{Nproveedor}]", [PermissionMiddleware::class], "add.sco_proveedor")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoProveedorAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoProveedorView[/{Nproveedor}]", [PermissionMiddleware::class], "view.sco_proveedor")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoProveedorView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoProveedorEdit[/{Nproveedor}]", [PermissionMiddleware::class], "edit.sco_proveedor")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoProveedorEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoProveedorDelete[/{Nproveedor}]", [PermissionMiddleware::class], "delete.sco_proveedor")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoProveedorDelete");
    }
}
