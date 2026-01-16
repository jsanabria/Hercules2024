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

class ScoAdjuntoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoAdjuntoList[/{Nadjunto}]", [PermissionMiddleware::class], "list.sco_adjunto")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoAdjuntoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoAdjuntoAdd[/{Nadjunto}]", [PermissionMiddleware::class], "add.sco_adjunto")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoAdjuntoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoAdjuntoView[/{Nadjunto}]", [PermissionMiddleware::class], "view.sco_adjunto")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoAdjuntoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoAdjuntoEdit[/{Nadjunto}]", [PermissionMiddleware::class], "edit.sco_adjunto")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoAdjuntoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoAdjuntoDelete[/{Nadjunto}]", [PermissionMiddleware::class], "delete.sco_adjunto")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoAdjuntoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoAdjuntoPreview", [PermissionMiddleware::class], "preview.sco_adjunto")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoAdjuntoPreview", null, false);
    }
}
