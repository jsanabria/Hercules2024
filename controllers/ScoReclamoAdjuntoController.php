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

class ScoReclamoAdjuntoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoAdjuntoList[/{Nreclamo_adjunto}]", [PermissionMiddleware::class], "list.sco_reclamo_adjunto")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoAdjuntoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoAdjuntoAdd[/{Nreclamo_adjunto}]", [PermissionMiddleware::class], "add.sco_reclamo_adjunto")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoAdjuntoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoAdjuntoView[/{Nreclamo_adjunto}]", [PermissionMiddleware::class], "view.sco_reclamo_adjunto")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoAdjuntoView");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoAdjuntoDelete[/{Nreclamo_adjunto}]", [PermissionMiddleware::class], "delete.sco_reclamo_adjunto")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoAdjuntoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoReclamoAdjuntoPreview", [PermissionMiddleware::class], "preview.sco_reclamo_adjunto")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoAdjuntoPreview", null, false);
    }
}
