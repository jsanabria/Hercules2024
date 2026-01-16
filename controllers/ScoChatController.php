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

class ScoChatController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoChatList[/{Nchat}]", [PermissionMiddleware::class], "list.sco_chat")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoChatList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoChatView[/{Nchat}]", [PermissionMiddleware::class], "view.sco_chat")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoChatView");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoChatDelete[/{Nchat}]", [PermissionMiddleware::class], "delete.sco_chat")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoChatDelete");
    }
}
