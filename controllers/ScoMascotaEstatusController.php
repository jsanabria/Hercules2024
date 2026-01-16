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

class ScoMascotaEstatusController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoMascotaEstatusList[/{keys:.*}]", [PermissionMiddleware::class], "list.sco_mascota_estatus")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ScoMascotaEstatusList");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoMascotaEstatusDelete[/{keys:.*}]", [PermissionMiddleware::class], "delete.sco_mascota_estatus")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ScoMascotaEstatusDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoMascotaEstatusPreview", [PermissionMiddleware::class], "preview.sco_mascota_estatus")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ScoMascotaEstatusPreview", null, false);
    }

    // Get keys as associative array
    protected function getKeyParams($args)
    {
        global $RouteValues;
        if (array_key_exists("keys", $args)) {
            $sep = Container("sco_mascota_estatus")->RouteCompositeKeySeparator;
            $keys = explode($sep, $args["keys"]);
            if (count($keys) == 2) {
                $keyArgs = array_combine(["mascota","estatus"], $keys);
                $RouteValues = array_merge(Route(), $keyArgs);
                $args = array_merge($args, $keyArgs);
            }
        }
        return $args;
    }
}
