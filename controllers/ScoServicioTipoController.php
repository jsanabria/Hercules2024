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

class ScoServicioTipoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoServicioTipoList[/{Nservicio_tipo:.*}]", [PermissionMiddleware::class], "list.sco_servicio_tipo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoServicioTipoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoServicioTipoAdd[/{Nservicio_tipo:.*}]", [PermissionMiddleware::class], "add.sco_servicio_tipo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoServicioTipoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoServicioTipoView[/{Nservicio_tipo:.*}]", [PermissionMiddleware::class], "view.sco_servicio_tipo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoServicioTipoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoServicioTipoEdit[/{Nservicio_tipo:.*}]", [PermissionMiddleware::class], "edit.sco_servicio_tipo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoServicioTipoEdit");
    }
}
