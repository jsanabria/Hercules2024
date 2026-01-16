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

class ScoSmsQwertyController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoSmsQwertyList[/{Nsms_qwerty}]", [PermissionMiddleware::class], "list.sco_sms_qwerty")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoSmsQwertyList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoSmsQwertyView[/{Nsms_qwerty}]", [PermissionMiddleware::class], "view.sco_sms_qwerty")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoSmsQwertyView");
    }
}
