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
 * tasa_cambio_guardar controller
 */
class TasaCambioGuardarController extends ControllerBase
{
    // custom
    #[Map(["GET", "POST", "OPTIONS"], "/TasaCambioGuardar[/{params:.*}]", [PermissionMiddleware::class], "custom.tasa_cambio_guardar")]
    public function custom(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TasaCambioGuardar");
    }
}
