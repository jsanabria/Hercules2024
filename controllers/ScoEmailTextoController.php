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

class ScoEmailTextoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoEmailTextoList[/{Nemail_texto}]", [PermissionMiddleware::class], "list.sco_email_texto")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmailTextoList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoEmailTextoAdd[/{Nemail_texto}]", [PermissionMiddleware::class], "add.sco_email_texto")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmailTextoAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoEmailTextoView[/{Nemail_texto}]", [PermissionMiddleware::class], "view.sco_email_texto")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmailTextoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoEmailTextoEdit[/{Nemail_texto}]", [PermissionMiddleware::class], "edit.sco_email_texto")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmailTextoEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoEmailTextoDelete[/{Nemail_texto}]", [PermissionMiddleware::class], "delete.sco_email_texto")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmailTextoDelete");
    }
}
