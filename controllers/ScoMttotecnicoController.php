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

class ScoMttotecnicoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoList[/{Nmttotecnico}]", [PermissionMiddleware::class], "list.sco_mttotecnico")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoAdd[/{Nmttotecnico}]", [PermissionMiddleware::class], "add.sco_mttotecnico")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoView[/{Nmttotecnico}]", [PermissionMiddleware::class], "view.sco_mttotecnico")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoEdit[/{Nmttotecnico}]", [PermissionMiddleware::class], "edit.sco_mttotecnico")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoMttotecnicoDelete[/{Nmttotecnico}]", [PermissionMiddleware::class], "delete.sco_mttotecnico")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoMttotecnicoDelete");
    }
}
