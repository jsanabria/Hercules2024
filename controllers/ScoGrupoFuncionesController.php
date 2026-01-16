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

class ScoGrupoFuncionesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoGrupoFuncionesList[/{Ngrupo_funciones}]", [PermissionMiddleware::class], "list.sco_grupo_funciones")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGrupoFuncionesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoGrupoFuncionesAdd[/{Ngrupo_funciones}]", [PermissionMiddleware::class], "add.sco_grupo_funciones")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGrupoFuncionesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoGrupoFuncionesView[/{Ngrupo_funciones}]", [PermissionMiddleware::class], "view.sco_grupo_funciones")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGrupoFuncionesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoGrupoFuncionesEdit[/{Ngrupo_funciones}]", [PermissionMiddleware::class], "edit.sco_grupo_funciones")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGrupoFuncionesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoGrupoFuncionesDelete[/{Ngrupo_funciones}]", [PermissionMiddleware::class], "delete.sco_grupo_funciones")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGrupoFuncionesDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoGrupoFuncionesPreview", [PermissionMiddleware::class], "preview.sco_grupo_funciones")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGrupoFuncionesPreview", null, false);
    }
}
