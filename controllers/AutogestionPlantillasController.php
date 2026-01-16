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

class AutogestionPlantillasController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/AutogestionPlantillasList[/{Nplantilla}]", [PermissionMiddleware::class], "list.autogestion_plantillas")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AutogestionPlantillasList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/AutogestionPlantillasAdd[/{Nplantilla}]", [PermissionMiddleware::class], "add.autogestion_plantillas")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AutogestionPlantillasAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/AutogestionPlantillasView[/{Nplantilla}]", [PermissionMiddleware::class], "view.autogestion_plantillas")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AutogestionPlantillasView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/AutogestionPlantillasEdit[/{Nplantilla}]", [PermissionMiddleware::class], "edit.autogestion_plantillas")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AutogestionPlantillasEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/AutogestionPlantillasDelete[/{Nplantilla}]", [PermissionMiddleware::class], "delete.autogestion_plantillas")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AutogestionPlantillasDelete");
    }
}
