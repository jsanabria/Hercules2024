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

class ScoGramaNotaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaNotaList[/{Nnota}]", [PermissionMiddleware::class], "list.sco_grama_nota")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaNotaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaNotaAdd[/{Nnota}]", [PermissionMiddleware::class], "add.sco_grama_nota")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaNotaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaNotaView[/{Nnota}]", [PermissionMiddleware::class], "view.sco_grama_nota")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaNotaView");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaNotaDelete[/{Nnota}]", [PermissionMiddleware::class], "delete.sco_grama_nota")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaNotaDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoGramaNotaPreview", [PermissionMiddleware::class], "preview.sco_grama_nota")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaNotaPreview", null, false);
    }
}
