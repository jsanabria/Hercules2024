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

class ScoNotificacionesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoNotificacionesList[/{Nnotificaciones}]", [PermissionMiddleware::class], "list.sco_notificaciones")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotificacionesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoNotificacionesAdd[/{Nnotificaciones}]", [PermissionMiddleware::class], "add.sco_notificaciones")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotificacionesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoNotificacionesView[/{Nnotificaciones}]", [PermissionMiddleware::class], "view.sco_notificaciones")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotificacionesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoNotificacionesEdit[/{Nnotificaciones}]", [PermissionMiddleware::class], "edit.sco_notificaciones")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotificacionesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoNotificacionesDelete[/{Nnotificaciones}]", [PermissionMiddleware::class], "delete.sco_notificaciones")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotificacionesDelete");
    }
}
