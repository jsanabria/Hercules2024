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

class ScoOrdenController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenList[/{Norden}]", [PermissionMiddleware::class], "list.sco_orden")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenAdd[/{Norden}]", [PermissionMiddleware::class], "add.sco_orden")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenView[/{Norden}]", [PermissionMiddleware::class], "view.sco_orden")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenView");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoOrdenDelete[/{Norden}]", [PermissionMiddleware::class], "delete.sco_orden")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoOrdenPreview", [PermissionMiddleware::class], "preview.sco_orden")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoOrdenPreview", null, false);
    }
}
