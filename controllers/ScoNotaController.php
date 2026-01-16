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

class ScoNotaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoNotaList[/{Nnota}]", [PermissionMiddleware::class], "list.sco_nota")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoNotaAdd[/{Nnota}]", [PermissionMiddleware::class], "add.sco_nota")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoNotaView[/{Nnota}]", [PermissionMiddleware::class], "view.sco_nota")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaView");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoNotaDelete[/{Nnota}]", [PermissionMiddleware::class], "delete.sco_nota")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoNotaPreview", [PermissionMiddleware::class], "preview.sco_nota")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaPreview", null, false);
    }
}
