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

class ScoChatGrupoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoChatGrupoList[/{Ngrupo_chat}]", [PermissionMiddleware::class], "list.sco_chat_grupo")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoChatGrupoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoChatGrupoAdd[/{Ngrupo_chat}]", [PermissionMiddleware::class], "add.sco_chat_grupo")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoChatGrupoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoChatGrupoView[/{Ngrupo_chat}]", [PermissionMiddleware::class], "view.sco_chat_grupo")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoChatGrupoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoChatGrupoEdit[/{Ngrupo_chat}]", [PermissionMiddleware::class], "edit.sco_chat_grupo")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoChatGrupoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoChatGrupoDelete[/{Ngrupo_chat}]", [PermissionMiddleware::class], "delete.sco_chat_grupo")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoChatGrupoDelete");
    }
}
