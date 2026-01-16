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

class ScoCremacionEstatusController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoCremacionEstatusList[/{keys:.*}]", [PermissionMiddleware::class], "list.sco_cremacion_estatus")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ScoCremacionEstatusList");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoCremacionEstatusDelete[/{keys:.*}]", [PermissionMiddleware::class], "delete.sco_cremacion_estatus")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ScoCremacionEstatusDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoCremacionEstatusPreview", [PermissionMiddleware::class], "preview.sco_cremacion_estatus")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ScoCremacionEstatusPreview", null, false);
    }

    // Get keys as associative array
    protected function getKeyParams($args)
    {
        global $RouteValues;
        if (array_key_exists("keys", $args)) {
            $sep = Container("sco_cremacion_estatus")->RouteCompositeKeySeparator;
            $keys = explode($sep, $args["keys"]);
            if (count($keys) == 2) {
                $keyArgs = array_combine(["expediente","estatus"], $keys);
                $RouteValues = array_merge(Route(), $keyArgs);
                $args = array_merge($args, $keyArgs);
            }
        }
        return $args;
    }
}
