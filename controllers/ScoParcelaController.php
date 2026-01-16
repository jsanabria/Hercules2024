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

class ScoParcelaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaList[/{Nparcela}]", [PermissionMiddleware::class], "list.sco_parcela")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaAdd[/{Nparcela}]", [PermissionMiddleware::class], "add.sco_parcela")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaView[/{Nparcela}]", [PermissionMiddleware::class], "view.sco_parcela")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaEdit[/{Nparcela}]", [PermissionMiddleware::class], "edit.sco_parcela")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoParcelaDelete[/{Nparcela}]", [PermissionMiddleware::class], "delete.sco_parcela")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoParcelaPreview", [PermissionMiddleware::class], "preview.sco_parcela")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoParcelaPreview", null, false);
    }
}
