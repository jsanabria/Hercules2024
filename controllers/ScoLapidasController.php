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

class ScoLapidasController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasList[/{Nlapidas}]", [PermissionMiddleware::class], "list.sco_lapidas")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoLapidasView[/{Nlapidas}]", [PermissionMiddleware::class], "view.sco_lapidas")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoLapidasView");
    }
}
