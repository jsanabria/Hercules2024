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

class ScoReservaOldController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoReservaOldList[/{Nreserva}]", [PermissionMiddleware::class], "list.sco_reserva_old")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReservaOldList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoReservaOldAdd[/{Nreserva}]", [PermissionMiddleware::class], "add.sco_reserva_old")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReservaOldAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoReservaOldView[/{Nreserva}]", [PermissionMiddleware::class], "view.sco_reserva_old")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReservaOldView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoReservaOldEdit[/{Nreserva}]", [PermissionMiddleware::class], "edit.sco_reserva_old")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReservaOldEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoReservaOldDelete[/{Nreserva}]", [PermissionMiddleware::class], "delete.sco_reserva_old")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReservaOldDelete");
    }
}
