<?php
/**
 * Created by PhpStorm.
 * User: HiraldoTran
 * Date: 16/7/18
 * Time: 11:41 AM
 */

namespace AppBundle\Security;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;


class AccessDeniedHandler implements AccessDeniedHandlerInterface
{



    private $router;

    public function __construct(  RouterInterface $router) {

        $this->router = $router;
    }

    /**
     * Handles an access denied failure.
     *
     * @return Response may return null
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {

        return new RedirectResponse($this->router->generate('home'));
    }


}