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

class ScoNotaMascotaController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoNotaMascotaList[/{Nnota_mascota}]", [PermissionMiddleware::class], "list.sco_nota_mascota")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaMascotaList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoNotaMascotaAdd[/{Nnota_mascota}]", [PermissionMiddleware::class], "add.sco_nota_mascota")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaMascotaAdd");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoNotaMascotaDelete[/{Nnota_mascota}]", [PermissionMiddleware::class], "delete.sco_nota_mascota")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaMascotaDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoNotaMascotaPreview", [PermissionMiddleware::class], "preview.sco_nota_mascota")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ScoNotaMascotaPreview", null, false);
    }
}
