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

class AutogestionTicketController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/AutogestionTicketList[/{Nticket}]", [PermissionMiddleware::class], "list.autogestion_ticket")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AutogestionTicketList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/AutogestionTicketView[/{Nticket}]", [PermissionMiddleware::class], "view.autogestion_ticket")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AutogestionTicketView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/AutogestionTicketEdit[/{Nticket}]", [PermissionMiddleware::class], "edit.autogestion_ticket")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AutogestionTicketEdit");
    }
}
