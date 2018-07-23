<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Objeto;
use AppBundle\Form\Type\ObjetoFormType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller{
    /**
     * @Route("/", name="entrar")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function entrarAction(Request $request){
        //Si el usuario está logueado se redirecciona a la página principal
        if(is_object($this->getUser())){
            return $this->redirect('inicio');
        }else{
            return $this->redirect('login');
        }
    }

    /**
     * @Route("/presentacion", name="presentacion")
     */
    public function landingAction(Request $request){
        return $this->render('landing/landing.html.twig');
    }

    /**
     * @Route("/inicio", name="inicio")
     */
    public function indexAction(Request $request){
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
            ->where('p.activo = true')
            ->orderBy('p.favorito', 'DESC')
            ->addOrderBy('p.fecha', 'DESC')
            ->getQuery()
            ->getResult();

        return $query;
    }

    /**
     * @Route("/objeto/editar/{id}", name="editar_objeto")
     * @Route("/objeto/añadir", name="add_objeto")
     * @param Request $request
     * @param Objeto|null $objeto
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\OptimisticLockException* @internal param Rutina|null $rutina
     */
    public function addObjetoAction(Request $request, Objeto $objeto = null){
        $fecha_at = new \Datetime("now");

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        if ($objeto == null) {
            $objeto = new Objeto();
            $em->persist($objeto);
            $objeto->setUsuario($usuario);
            $objeto->setFecha($fecha_at);
        }
        $form = $this->createForm(ObjetoFormType::class, $objeto);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if ($form->isValid()) {
                if($objeto->getUsuario()->getId() == $usuario->getId() || $this->getUser()->isAdmin()) {
                    try{
                        $flush = $em->flush();
                        if ($flush == null) {
                            if (null == $objeto) {
                                $this->addFlash('estado', 'El objeto se ha creado correctamente');
                            } else {
                                $this->addFlash('estado', 'Los cambios se han guardado correctamente');
                            }
                        } else {
                            if (null == $objeto) {
                                $this->addFlash('error', 'Error al añadir el objeto');
                            } else {
                                $this->addFlash('error', 'Los cambios no se han guardado correctamente');
                            }
                        }
                    }catch (Exception $exception){
                        if (null == $objeto) {
                            $this->addFlash('error', 'No tienes permisos para agregar este objeto');
                        } else {
                            $this->addFlash('error', 'No puedes modificar este objeto');
                        }
                    }
                }
            } else {
                if (null == $objeto) {
                    $this->addFlash('error', 'El objeto no se ha creado porque el formulario no es válido');
                } else {
                    $this->addFlash('error', 'Los cambios no se han guardado porque el formulario no es válido');
                }
            }
            return $this->redirectToRoute('inicio');
        }
        return $this->render('Objeto/objeto.html.twig', [
            'formulario' => $form->createView(),
            'fecha_at' => $fecha_at
        ]);
    }

    /**
     * @Route("/favorito", name="objeto_favorito", methods={"POST"})
     */
    public function favoritoAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $objeto = $em->getRepository('AppBundle:Objeto')
            ->findOneBy([
                'id' => $request->get('fav'),
                'usuario' => $this->getUser()
            ]);
        try{
            if($objeto->isFavorito()){
                $objeto->setFavorito(0);
            }else{
                $objeto->setFavorito(1);
            }

            $em->flush();
        }catch (Exception $exception){
            $this->addFlash('error', 'Hubo algún problema al procesar la petición');
        }
        die();
    }

    /**
     * @Route("/favoritos", name="todos_favoritos", methods={"POST"})
     */
    public function favoritosAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $objetos = $em->getRepository('AppBundle:Objeto')
            ->findBy([
                'usuario' => $this->getUser()
            ]);
        try{
            $todos_fav = true;
            foreach($objetos as $objeto) {
                if(!$objeto->isFavorito()){
                    $objeto->setFavorito(1);
                    $todos_fav = false;
                }
            }
            if($todos_fav){
                foreach($objetos as $objeto) {
                    $objeto->setFavorito(0);
                    $todos_fav = true;
                }
            }

            $em->flush();
        }catch (Exception $exception){
            $this->addFlash('error', 'Hubo algún problema al procesar la petición');
        }
        die();
    }

    /**
     * @Route("/eliminar/objeto/{id}", name="confirmar_borrar_objeto", methods={"GET"})
     * @param Objeto $objeto
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function borrarDeVerdadAction(Objeto $objeto){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($objeto);
            $em->flush();
            $this->addFlash('estado', 'El objeto se ha eliminado con éxito');
        }
        catch(Exception $e) {
            $this->addFlash('error', 'Hubo algún error. No se ha podido eliminar el objeto');
        }
        return $this->redirect($this->generateUrl('inicio'));
    }
}
