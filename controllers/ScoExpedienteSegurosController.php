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

class ScoExpedienteSegurosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteSegurosList[/{Nexpediente_seguros}]", [PermissionMiddleware::class], "list.sco_expediente_seguros")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteSegurosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteSegurosAdd[/{Nexpediente_seguros}]", [PermissionMiddleware::class], "add.sco_expediente_seguros")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteSegurosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteSegurosView[/{Nexpediente_seguros}]", [PermissionMiddleware::class], "view.sco_expediente_seguros")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteSegurosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteSegurosEdit[/{Nexpediente_seguros}]", [PermissionMiddleware::class], "edit.sco_expediente_seguros")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteSegurosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteSegurosDelete[/{Nexpediente_seguros}]", [PermissionMiddleware::class], "delete.sco_expediente_seguros")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoExpedienteSegurosDelete");
    }
}
