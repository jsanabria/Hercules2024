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

class ScoReembolsoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoReembolsoList[/{Nreembolso}]", [PermissionMiddleware::class], "list.sco_reembolso")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReembolsoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoReembolsoAdd[/{Nreembolso}]", [PermissionMiddleware::class], "add.sco_reembolso")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReembolsoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoReembolsoView[/{Nreembolso}]", [PermissionMiddleware::class], "view.sco_reembolso")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReembolsoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoReembolsoEdit[/{Nreembolso}]", [PermissionMiddleware::class], "edit.sco_reembolso")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReembolsoEdit");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoReembolsoPreview", [PermissionMiddleware::class], "preview.sco_reembolso")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReembolsoPreview", null, false);
    }
}
