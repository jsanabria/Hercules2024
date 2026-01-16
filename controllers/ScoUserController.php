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

class ScoUserController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoUserList[/{Nuser}]", [PermissionMiddleware::class], "list.sco_user")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoUserAdd[/{Nuser}]", [PermissionMiddleware::class], "add.sco_user")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoUserView[/{Nuser}]", [PermissionMiddleware::class], "view.sco_user")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoUserEdit[/{Nuser}]", [PermissionMiddleware::class], "edit.sco_user")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoUserDelete[/{Nuser}]", [PermissionMiddleware::class], "delete.sco_user")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoUserDelete");
    }
}
