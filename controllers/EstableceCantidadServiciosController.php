<?php

namespace PHPMaker2024\hercules;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\hercules\Attributes\Delete;
use PHPMaker2024\hercules\Attributes\Get;
use PHPMaker2024\hercules\Attributes\Map;
use PHPMaker2024\hercules\Attributes\Options;
use PHPMaker2024\hercules\Attributes\Patch;
use PHPMaker2024\hercules\Attributes\Post;
use PHPMaker2024\hercules\Attributes\Put;

/**
 * establece_cantidad_servicios controller
 */
class EstableceCantidadServiciosController extends ControllerBase
{
    // custom
    #[Map(["GET", "POST", "OPTIONS"], "/dashboard/EstableceCantidadServicios[/{params:.*}]", [PermissionMiddleware::class], "custom.establece_cantidad_servicios")]
    public function custom(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "EstableceCantidadServicios");
    }
}
