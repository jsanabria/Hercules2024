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

class ViewVelacionController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ViewVelacionList[/{Nservicio:.*}]", [PermissionMiddleware::class], "list.view_velacion")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewVelacionList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ViewVelacionAdd[/{Nservicio:.*}]", [PermissionMiddleware::class], "add.view_velacion")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewVelacionAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ViewVelacionView[/{Nservicio:.*}]", [PermissionMiddleware::class], "view.view_velacion")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewVelacionView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ViewVelacionEdit[/{Nservicio:.*}]", [PermissionMiddleware::class], "edit.view_velacion")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewVelacionEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ViewVelacionDelete[/{Nservicio:.*}]", [PermissionMiddleware::class], "delete.view_velacion")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ViewVelacionDelete");
    }
}
