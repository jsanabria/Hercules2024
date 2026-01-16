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

class ScoLapidasNotasController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasNotasList[/{Nlapidas_notas}]", [PermissionMiddleware::class], "list.sco_lapidas_notas")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasNotasList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasNotasAdd[/{Nlapidas_notas}]", [PermissionMiddleware::class], "add.sco_lapidas_notas")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasNotasAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasNotasView[/{Nlapidas_notas}]", [PermissionMiddleware::class], "view.sco_lapidas_notas")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasNotasView");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoLapidasNotasPreview", [PermissionMiddleware::class], "preview.sco_lapidas_notas")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasNotasPreview", null, false);
    }
}
