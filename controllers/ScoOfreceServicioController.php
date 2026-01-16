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

class ScoOfreceServicioController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoOfreceServicioList[/{Nfrece_servicio}]", [PermissionMiddleware::class], "list.sco_ofrece_servicio")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOfreceServicioList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoOfreceServicioAdd[/{Nfrece_servicio}]", [PermissionMiddleware::class], "add.sco_ofrece_servicio")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOfreceServicioAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoOfreceServicioView[/{Nfrece_servicio}]", [PermissionMiddleware::class], "view.sco_ofrece_servicio")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOfreceServicioView");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoOfreceServicioDelete[/{Nfrece_servicio}]", [PermissionMiddleware::class], "delete.sco_ofrece_servicio")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOfreceServicioDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoOfreceServicioPreview", [PermissionMiddleware::class], "preview.sco_ofrece_servicio")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOfreceServicioPreview", null, false);
    }
}
