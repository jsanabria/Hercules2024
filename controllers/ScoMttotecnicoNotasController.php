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

class ScoMttotecnicoNotasController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoNotasList[/{Nmttotecnico_notas}]", [PermissionMiddleware::class], "list.sco_mttotecnico_notas")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoNotasList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoNotasAdd[/{Nmttotecnico_notas}]", [PermissionMiddleware::class], "add.sco_mttotecnico_notas")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoNotasAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoNotasView[/{Nmttotecnico_notas}]", [PermissionMiddleware::class], "view.sco_mttotecnico_notas")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoNotasView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoNotasEdit[/{Nmttotecnico_notas}]", [PermissionMiddleware::class], "edit.sco_mttotecnico_notas")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoNotasEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoNotasDelete[/{Nmttotecnico_notas}]", [PermissionMiddleware::class], "delete.sco_mttotecnico_notas")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoNotasDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoMttotecnicoNotasPreview", [PermissionMiddleware::class], "preview.sco_mttotecnico_notas")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoNotasPreview", null, false);
    }
}
