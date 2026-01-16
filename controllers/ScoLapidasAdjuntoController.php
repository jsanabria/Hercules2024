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

class ScoLapidasAdjuntoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasAdjuntoList[/{Nlapidas_adjunto}]", [PermissionMiddleware::class], "list.sco_lapidas_adjunto")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasAdjuntoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasAdjuntoAdd[/{Nlapidas_adjunto}]", [PermissionMiddleware::class], "add.sco_lapidas_adjunto")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasAdjuntoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasAdjuntoView[/{Nlapidas_adjunto}]", [PermissionMiddleware::class], "view.sco_lapidas_adjunto")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasAdjuntoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasAdjuntoEdit[/{Nlapidas_adjunto}]", [PermissionMiddleware::class], "edit.sco_lapidas_adjunto")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasAdjuntoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasAdjuntoDelete[/{Nlapidas_adjunto}]", [PermissionMiddleware::class], "delete.sco_lapidas_adjunto")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasAdjuntoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoLapidasAdjuntoPreview", [PermissionMiddleware::class], "preview.sco_lapidas_adjunto")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasAdjuntoPreview", null, false);
    }
}
