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

class ScoUserAdjuntoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoUserAdjuntoList[/{Nuser_adjunto}]", [PermissionMiddleware::class], "list.sco_user_adjunto")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserAdjuntoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoUserAdjuntoAdd[/{Nuser_adjunto}]", [PermissionMiddleware::class], "add.sco_user_adjunto")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserAdjuntoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoUserAdjuntoView[/{Nuser_adjunto}]", [PermissionMiddleware::class], "view.sco_user_adjunto")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserAdjuntoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoUserAdjuntoEdit[/{Nuser_adjunto}]", [PermissionMiddleware::class], "edit.sco_user_adjunto")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserAdjuntoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoUserAdjuntoDelete[/{Nuser_adjunto}]", [PermissionMiddleware::class], "delete.sco_user_adjunto")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserAdjuntoDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoUserAdjuntoPreview", [PermissionMiddleware::class], "preview.sco_user_adjunto")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserAdjuntoPreview", null, false);
    }
}
