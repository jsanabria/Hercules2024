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

class ScoEmbalajeController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoEmbalajeList[/{Nembalaje}]", [PermissionMiddleware::class], "list.sco_embalaje")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmbalajeList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoEmbalajeAdd[/{Nembalaje}]", [PermissionMiddleware::class], "add.sco_embalaje")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmbalajeAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoEmbalajeView[/{Nembalaje}]", [PermissionMiddleware::class], "view.sco_embalaje")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmbalajeView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoEmbalajeEdit[/{Nembalaje}]", [PermissionMiddleware::class], "edit.sco_embalaje")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmbalajeEdit");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoEmbalajePreview", [PermissionMiddleware::class], "preview.sco_embalaje")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmbalajePreview", null, false);
    }
}
