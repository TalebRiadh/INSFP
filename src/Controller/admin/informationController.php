<?php

namespace App\Controller\admin;

use App\Entity\Specialite;
use App\Entity\Module;
use App\Form\SpecialiteType;
use App\Form\ModuleType;
use App\Repository\SpecialiteRepository;
use App\Repository\ModuleRepository;

use Symfony\Component\Security\Core\User\UserInterface\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Twig\Environment;
class informationController extends AbstractController
{


    /**
     * @var SpecialiteRepository
     */
    
    private $repository;
     /**
     * @var ModuleRepository
     */
    
    private $r;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ModuleRepository $r,SpecialiteRepository $repository, ObjectManager $em)
    {
        $this->r = $r;
       $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/specialite",name="specialite")
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response

     */

    public function index()
    {
        /*
            $spc = $this->repository->find(1);
             $spc->getModules();
             foreach ($spc->getModules() as $module) {
            dump($module);
        }
        */
            $specliate = new Specialite();
            $module = new Module();
            $form = $this->createForm(SpecialiteType::class, $specliate );
            $module_f = $this->createForm(ModuleType::class, $module);
            $specialites = $this->repository->findall();
            dump($specialites);
            foreach ($specialites as $spc) {
                foreach ($spc->getModules() as $module) {
        }
    }

        return $this->render('Admin/option/index.html.twig', [
            'current' => 3,
            'specliates' => $specialites,
            'form' => $form->createView(),
            'form_m'=> $module_f->createView()
        ]);
    }




  /**
     * @Route("/admin/specialite_ajax",name="ajout_spc",options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
    public function ajaxAction(Request $request)
{
        $specialite = new Specialite();
        /* get last id */
        $lastQuestion = $this->repository->findOneBy([], ['id' => 'desc']);
        $id = $lastQuestion->getId();
        $spc = $request->request->get('spc');

        $specialite->setName($spc);
        $this->em->persist($specialite);
        $this->em->flush();
        $response = new Response(json_encode(array(
        'id' => $id+1,
        'specialité' => $spc
    )));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
}
  /**
     * @Route("/admin/specialite/module_add_ajax",name="ajout_module",options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
    public function module_add_ajax(Request $request)
{
        $module = new Module();
        $specialite = $this->repository->find($request->request->get('id'));
        $module->setNom($request->request->get('add'));
        $module->setSpecialite($specialite);
        $this->em->persist($module);
        $this->em->flush();
        $response = new Response(json_encode(array(
        'message' => 'bien ajouter',
    )));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
}

/**
     * @Route("/admin/specialite/module_delete_ajax",name="delete_module",options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
    public function module_delete_ajax(Request $request)
{
        $module=$request->request->get('module');
        $qb = $this->em->createQueryBuilder();
$qb->delete('App\Entity\Module', 'md');
$qb->where('md.nom = :module');
$qb->setParameter(':module', $module);
$qb->getQuery()->execute();
        $response = new Response(json_encode(array(
        'message' => 'bien suppprimer',
    )));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
}


    /**
     * @Route("/admin/specialite/{id}", name="admin.specialite.edit",methods="GET|POST")
     * @param Specialite $specialite
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Specialite $specialite, Request $request)
    {
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $specialite = new Specialite();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'bien modifié avec succés');
            return $this->redirectToRoute('specialite');
        }

        return $this->render('admin/option/edit.html.twig', [
            'specialite' => $specialite,
            'form' => $form->createView(),
            'current' => 3

        ]);

    }
 /**
     * @Route("/admin/specialite/{id}/module", name="admin.module.edit",methods="GET|POST")
     * @param Specialite $specialite
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit_m(Specialite $specialite, Request $request)
    {
        $module = new Module();
        $module_f = $this->createForm(ModuleType::class, $module);

        $module_f->handleRequest($request);
        if ($module_f->isSubmitted() && $module_f->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'bien modifié avec succés');
            return $this->redirectToRoute('specialite');
        }

        return $this->render('admin/option/edit_m.html.twig', [
            'specialite' => $specialite,
            'form_m' => $module_f->createView(),
            'current' => 3

        ]);

    }
    /**
     * @Route("/admin/specialite/{id}", name="admin.specialite.delete",methods="DELETE")
     * @param Specialite $specialite
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function remove(Specialite $specialite, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $specialite->getId(), $request->get('_token'))) {
            $this->em->remove($specialite);
            $this->em->flush();
            $this->addFlash('success', 'Specialité supprimé avec succés');
        }
        return $this->redirectToRoute('specialite');
    }


}

?>