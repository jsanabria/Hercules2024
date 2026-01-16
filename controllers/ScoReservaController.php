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

class ScoReservaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoReservaList[/{id}]", [PermissionMiddleware::class], "list.sco_reserva")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReservaList");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoReservaDelete[/{id}]", [PermissionMiddleware::class], "delete.sco_reserva")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoReservaDelete");
    }
}
