<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="entrar")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function entrarAction(Request $request)
    {
        //Si el usuario está logueado se redirecciona a la página principal
        if(is_object($this->getUser())){
            return $this->redirect('inicio');
        }else{
            return $this->redirect('login');
        }
    }

    /**
     * @Route("/inicio", name="inicio")
     */
    public function indexAction(Request $request)
    {
        $objetos = $this->getObjetos($request);


        return $this->render('default/index.html.twig',[
            'objetos' => $objetos
        ]);
    }

    public function getObjetos($request){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        //$usuario = $this->getUser();
        $objetos_repo = $em->getRepository('AppBundle:Objeto');
        $query = $objetos_repo->createQueryBuilder('p')
            //->where('p.id = (:user_id)')
            //->setParameter('user_id', $usuario->getId())
            ->orderBy('p.fecha', 'DESC')
            ->getQuery()
            ->getResult();

        return $query;
    }
}
