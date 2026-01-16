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

class ScoGramaAdjuntoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaAdjuntoList[/{Nadjunto}]", [PermissionMiddleware::class], "list.sco_grama_adjunto")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaAdjuntoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaAdjuntoAdd[/{Nadjunto}]", [PermissionMiddleware::class], "add.sco_grama_adjunto")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaAdjuntoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaAdjuntoView[/{Nadjunto}]", [PermissionMiddleware::class], "view.sco_grama_adjunto")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaAdjuntoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaAdjuntoEdit[/{Nadjunto}]", [PermissionMiddleware::class], "edit.sco_grama_adjunto")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaAdjuntoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaAdjuntoDelete[/{Nadjunto}]", [PermissionMiddleware::class], "delete.sco_grama_adjunto")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaAdjuntoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoGramaAdjuntoPreview", [PermissionMiddleware::class], "preview.sco_grama_adjunto")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaAdjuntoPreview", null, false);
    }
}
