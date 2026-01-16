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

class ScoServicioController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoServicioList[/{Nservicio:.*}]", [PermissionMiddleware::class], "list.sco_servicio")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoServicioList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoServicioAdd[/{Nservicio:.*}]", [PermissionMiddleware::class], "add.sco_servicio")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoServicioAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoServicioView[/{Nservicio:.*}]", [PermissionMiddleware::class], "view.sco_servicio")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoServicioView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoServicioEdit[/{Nservicio:.*}]", [PermissionMiddleware::class], "edit.sco_servicio")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoServicioEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoServicioDelete[/{Nservicio:.*}]", [PermissionMiddleware::class], "delete.sco_servicio")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoServicioDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoServicioPreview", [PermissionMiddleware::class], "preview.sco_servicio")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoServicioPreview", null, false);
    }
}
