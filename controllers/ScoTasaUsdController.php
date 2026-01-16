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

class ScoTasaUsdController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoTasaUsdList[/{id}]", [PermissionMiddleware::class], "list.sco_tasa_usd")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTasaUsdList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoTasaUsdAdd[/{id}]", [PermissionMiddleware::class], "add.sco_tasa_usd")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTasaUsdAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoTasaUsdView[/{id}]", [PermissionMiddleware::class], "view.sco_tasa_usd")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoTasaUsdView");
    }
}
