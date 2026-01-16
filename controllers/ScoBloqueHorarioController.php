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

class ScoBloqueHorarioController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoBloqueHorarioList[/{Nbloque_horario}]", [PermissionMiddleware::class], "list.sco_bloque_horario")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoBloqueHorarioList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoBloqueHorarioAdd[/{Nbloque_horario}]", [PermissionMiddleware::class], "add.sco_bloque_horario")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoBloqueHorarioAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoBloqueHorarioView[/{Nbloque_horario}]", [PermissionMiddleware::class], "view.sco_bloque_horario")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoBloqueHorarioView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoBloqueHorarioEdit[/{Nbloque_horario}]", [PermissionMiddleware::class], "edit.sco_bloque_horario")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoBloqueHorarioEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoBloqueHorarioDelete[/{Nbloque_horario}]", [PermissionMiddleware::class], "delete.sco_bloque_horario")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoBloqueHorarioDelete");
    }
}
