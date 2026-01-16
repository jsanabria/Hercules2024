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

class ViewOficioReligiosoController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ViewOficioReligiosoList[/{keys:.*}]", [PermissionMiddleware::class], "list.view_oficio_religioso")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ViewOficioReligiosoList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ViewOficioReligiosoView[/{keys:.*}]", [PermissionMiddleware::class], "view.view_oficio_religioso")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ViewOficioReligiosoView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ViewOficioReligiosoEdit[/{keys:.*}]", [PermissionMiddleware::class], "edit.view_oficio_religioso")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "ViewOficioReligiosoEdit");
    }

    // Get keys as associative array
    protected function getKeyParams($args)
    {
        global $RouteValues;
        if (array_key_exists("keys", $args)) {
            $sep = Container("view_oficio_religioso")->RouteCompositeKeySeparator;
            $keys = explode($sep, $args["keys"]);
            if (count($keys) == 2) {
                $keyArgs = array_combine(["Norden","Nexpediente"], $keys);
                $RouteValues = array_merge(Route(), $keyArgs);
                $args = array_merge($args, $keyArgs);
            }
        }
        return $args;
    }
}
