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

class ScoReclamoNotaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoNotaList[/{Nreclamo_nota}]", [PermissionMiddleware::class], "list.sco_reclamo_nota")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoNotaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoNotaAdd[/{Nreclamo_nota}]", [PermissionMiddleware::class], "add.sco_reclamo_nota")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoNotaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoNotaView[/{Nreclamo_nota}]", [PermissionMiddleware::class], "view.sco_reclamo_nota")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoNotaView");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoReclamoNotaDelete[/{Nreclamo_nota}]", [PermissionMiddleware::class], "delete.sco_reclamo_nota")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoNotaDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoReclamoNotaPreview", [PermissionMiddleware::class], "preview.sco_reclamo_nota")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReclamoNotaPreview", null, false);
    }
}
