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

class ScoExpedienteEstatusController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteEstatusList[/{keys:.*}]", [PermissionMiddleware::class], "list.sco_expediente_estatus")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ScoExpedienteEstatusList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteEstatusAdd[/{keys:.*}]", [PermissionMiddleware::class], "add.sco_expediente_estatus")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ScoExpedienteEstatusAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteEstatusView[/{keys:.*}]", [PermissionMiddleware::class], "view.sco_expediente_estatus")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ScoExpedienteEstatusView");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ScoExpedienteEstatusDelete[/{keys:.*}]", [PermissionMiddleware::class], "delete.sco_expediente_estatus")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ScoExpedienteEstatusDelete");
    }

    // preview
    #[Map(["GET","OPTIONS"], "/ScoExpedienteEstatusPreview", [PermissionMiddleware::class], "preview.sco_expediente_estatus")]
    public function preview(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ScoExpedienteEstatusPreview", null, false);
    }

    // Get keys as associative array
    protected function getKeyParams($args)
    {
        global $RouteValues;
        if (array_key_exists("keys", $args)) {
            $sep = Container("sco_expediente_estatus")->RouteCompositeKeySeparator;
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
