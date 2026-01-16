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

class ScoAlertasController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoAlertasList[/{Nalerta}]", [PermissionMiddleware::class], "list.sco_alertas")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoAlertasList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoAlertasAdd[/{Nalerta}]", [PermissionMiddleware::class], "add.sco_alertas")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoAlertasAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoAlertasView[/{Nalerta}]", [PermissionMiddleware::class], "view.sco_alertas")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoAlertasView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoAlertasEdit[/{Nalerta}]", [PermissionMiddleware::class], "edit.sco_alertas")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoAlertasEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoAlertasDelete[/{Nalerta}]", [PermissionMiddleware::class], "delete.sco_alertas")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoAlertasDelete");
    }
}
