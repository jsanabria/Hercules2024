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

class ScoUserNotaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoUserNotaList[/{Nuser_nota}]", [PermissionMiddleware::class], "list.sco_user_nota")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserNotaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoUserNotaAdd[/{Nuser_nota}]", [PermissionMiddleware::class], "add.sco_user_nota")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserNotaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoUserNotaView[/{Nuser_nota}]", [PermissionMiddleware::class], "view.sco_user_nota")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserNotaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoUserNotaEdit[/{Nuser_nota}]", [PermissionMiddleware::class], "edit.sco_user_nota")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserNotaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoUserNotaDelete[/{Nuser_nota}]", [PermissionMiddleware::class], "delete.sco_user_nota")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserNotaDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoUserNotaPreview", [PermissionMiddleware::class], "preview.sco_user_nota")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserNotaPreview", null, false);
    }
}
