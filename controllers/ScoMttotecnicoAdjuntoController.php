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

class ScoMttotecnicoAdjuntoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoAdjuntoList[/{Nmttotecnico_adjunto}]", [PermissionMiddleware::class], "list.sco_mttotecnico_adjunto")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoAdjuntoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoAdjuntoAdd[/{Nmttotecnico_adjunto}]", [PermissionMiddleware::class], "add.sco_mttotecnico_adjunto")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoAdjuntoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoAdjuntoView[/{Nmttotecnico_adjunto}]", [PermissionMiddleware::class], "view.sco_mttotecnico_adjunto")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoAdjuntoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoAdjuntoEdit[/{Nmttotecnico_adjunto}]", [PermissionMiddleware::class], "edit.sco_mttotecnico_adjunto")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoAdjuntoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoAdjuntoDelete[/{Nmttotecnico_adjunto}]", [PermissionMiddleware::class], "delete.sco_mttotecnico_adjunto")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoAdjuntoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoMttotecnicoAdjuntoPreview", [PermissionMiddleware::class], "preview.sco_mttotecnico_adjunto")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoAdjuntoPreview", null, false);
    }
}
