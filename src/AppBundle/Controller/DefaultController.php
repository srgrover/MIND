<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Objeto;
use AppBundle\Form\Type\ObjetoFormType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @Route("/objeto/editar/{id}", name="editar_objeto")
     * @Route("/objeto/añadir", name="add_objeto")
     * @param Request $request
     * @param Objeto|null $objeto
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\OptimisticLockException* @internal param Rutina|null $rutina
     */
    public function addObjetoAction(Request $request, Objeto $objeto = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        if ($objeto == null) {
            $objeto = new Objeto();
            $em->persist($objeto);
            $objeto->setUsuario($usuario);
            $objeto->setFecha(new \Datetime("now"));
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
        ]);
    }

    /**
     * @Route("/objeto/{id}/favorito", name="objeto_favorito")
     * @param Objeto $id
     */
    public function peticionViajeAction(Objeto $id){
        $em = $this->getDoctrine()->getManager();
        $objeto = $em->getRepository('AppBundle:Objeto')
            ->findOneBy(['id' => $id]);
        try{
            $objeto->setFavorito(1);
            $em->flush();
            $this->addFlash('estado', 'Añadido a favoritos');
        }catch (Exception $exception){
            $this->addFlash('error', 'Hubo algún problema al procesar la petición');
        }
        die();
    }
}
