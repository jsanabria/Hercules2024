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

class ViewExpedienteFunerariaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ViewExpedienteFunerariaList[/{Norden}]", [PermissionMiddleware::class], "list.view_expediente_funeraria")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewExpedienteFunerariaList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ViewExpedienteFunerariaView[/{Norden}]", [PermissionMiddleware::class], "view.view_expediente_funeraria")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewExpedienteFunerariaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ViewExpedienteFunerariaEdit[/{Norden}]", [PermissionMiddleware::class], "edit.view_expediente_funeraria")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewExpedienteFunerariaEdit");
    }
}
