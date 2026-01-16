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

class ScoGramaPagosController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaPagosList[/{Ngrama_pagos}]", [PermissionMiddleware::class], "list.sco_grama_pagos")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaPagosList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaPagosAdd[/{Ngrama_pagos}]", [PermissionMiddleware::class], "add.sco_grama_pagos")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaPagosAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaPagosView[/{Ngrama_pagos}]", [PermissionMiddleware::class], "view.sco_grama_pagos")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaPagosView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaPagosEdit[/{Ngrama_pagos}]", [PermissionMiddleware::class], "edit.sco_grama_pagos")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaPagosEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoGramaPagosDelete[/{Ngrama_pagos}]", [PermissionMiddleware::class], "delete.sco_grama_pagos")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaPagosDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoGramaPagosPreview", [PermissionMiddleware::class], "preview.sco_grama_pagos")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoGramaPagosPreview", null, false);
    }
}
