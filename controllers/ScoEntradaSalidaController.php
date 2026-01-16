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

class ScoEntradaSalidaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoEntradaSalidaList[/{Nentrada_salida}]", [PermissionMiddleware::class], "list.sco_entrada_salida")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEntradaSalidaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoEntradaSalidaAdd[/{Nentrada_salida}]", [PermissionMiddleware::class], "add.sco_entrada_salida")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEntradaSalidaAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoEntradaSalidaView[/{Nentrada_salida}]", [PermissionMiddleware::class], "view.sco_entrada_salida")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEntradaSalidaView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoEntradaSalidaEdit[/{Nentrada_salida}]", [PermissionMiddleware::class], "edit.sco_entrada_salida")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEntradaSalidaEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoEntradaSalidaDelete[/{Nentrada_salida}]", [PermissionMiddleware::class], "delete.sco_entrada_salida")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEntradaSalidaDelete");
    }
}
