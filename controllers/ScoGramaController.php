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

class ScoGramaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaList[/{Ngrama}]", [PermissionMiddleware::class], "list.sco_grama")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaView[/{Ngrama}]", [PermissionMiddleware::class], "view.sco_grama")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaEdit[/{Ngrama}]", [PermissionMiddleware::class], "edit.sco_grama")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaDelete[/{Ngrama}]", [PermissionMiddleware::class], "delete.sco_grama")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaDelete");
    }
}
