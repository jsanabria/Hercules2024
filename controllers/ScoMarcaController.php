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

class ScoMarcaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoMarcaList[/{Nmarca}]", [PermissionMiddleware::class], "list.sco_marca")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMarcaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoMarcaAdd[/{Nmarca}]", [PermissionMiddleware::class], "add.sco_marca")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMarcaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoMarcaView[/{Nmarca}]", [PermissionMiddleware::class], "view.sco_marca")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMarcaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoMarcaEdit[/{Nmarca}]", [PermissionMiddleware::class], "edit.sco_marca")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMarcaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoMarcaDelete[/{Nmarca}]", [PermissionMiddleware::class], "delete.sco_marca")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMarcaDelete");
    }
}
