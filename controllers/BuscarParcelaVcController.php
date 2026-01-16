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
 * buscar_parcela_vc controller
 */
class BuscarParcelaVcController extends ControllerBase
{
    // custom
    #[Map(["GET", "POST", "OPTIONS"], "/BuscarParcelaVc[/{params:.*}]", [PermissionMiddleware::class], "custom.buscar_parcela_vc")]
    public function custom(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "BuscarParcelaVc");
    }
}
