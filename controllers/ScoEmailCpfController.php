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

class ScoEmailCpfController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoEmailCpfList[/{Nemail_cpf}]", [PermissionMiddleware::class], "list.sco_email_cpf")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmailCpfList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoEmailCpfView[/{Nemail_cpf}]", [PermissionMiddleware::class], "view.sco_email_cpf")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmailCpfView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoEmailCpfEdit[/{Nemail_cpf}]", [PermissionMiddleware::class], "edit.sco_email_cpf")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmailCpfEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoEmailCpfDelete[/{Nemail_cpf}]", [PermissionMiddleware::class], "delete.sco_email_cpf")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoEmailCpfDelete");
    }
}
