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

class ScoCiaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoCiaList[/{Ncia}]", [PermissionMiddleware::class], "list.sco_cia")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCiaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoCiaAdd[/{Ncia}]", [PermissionMiddleware::class], "add.sco_cia")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCiaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoCiaView[/{Ncia}]", [PermissionMiddleware::class], "view.sco_cia")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCiaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoCiaEdit[/{Ncia}]", [PermissionMiddleware::class], "edit.sco_cia")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCiaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoCiaDelete[/{Ncia}]", [PermissionMiddleware::class], "delete.sco_cia")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoCiaDelete");
    }
}
