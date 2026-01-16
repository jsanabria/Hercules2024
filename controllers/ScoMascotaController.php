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

class ScoMascotaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoMascotaList[/{Nmascota}]", [PermissionMiddleware::class], "list.sco_mascota")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMascotaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoMascotaAdd[/{Nmascota}]", [PermissionMiddleware::class], "add.sco_mascota")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMascotaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoMascotaView[/{Nmascota}]", [PermissionMiddleware::class], "view.sco_mascota")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMascotaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoMascotaEdit[/{Nmascota}]", [PermissionMiddleware::class], "edit.sco_mascota")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMascotaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoMascotaDelete[/{Nmascota}]", [PermissionMiddleware::class], "delete.sco_mascota")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMascotaDelete");
    }
}
