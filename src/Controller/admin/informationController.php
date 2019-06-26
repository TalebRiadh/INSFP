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
            $specliate = new Specialite();
            $module = new Module();
            $form = $this->createForm(SpecialiteType::class, $specliate );
            $module_f = $this->createForm(ModuleType::class, $module);
            $specialites = $this->repository->findall();


        return $this->render('Admin/option/index.html.twig', [
            'current' => 9,
            'specialites' => $specialites,
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
        $spc =$request->request->get('id');
          $qb = $this->repository->findOneBySomeField($spc);
        $module->setNom($request->request->get('add'));
        $module->setSpecialite_id($qb->getId());
        $this->em->persist($module);
        $this->em->flush();
        $response = new Response(json_encode(array(
        'message' => $qb,
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
            'current' => 9

        ]);

    }
 /**
     * @Route("/admin/specialite_module", name="admin.formation.specialite.create",methods="GET|POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newspecialite(Request $request)
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
            'form_m' => $module_f->createView(),
            'current' => 8

        ]);

    }

     /**
     * @Route("/admin/specialite/{id}/module", name="admin.module.edit",methods="GET|POST")
     * @param Specialite $specialite
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit_module(Specialite $specialite, Request $request)
    {
        $module = new Module();
        $module_f = $this->createForm(ModuleType::class, $module);
        $modules_spcl = $this->r->findBy(array('specialite_id' => $specialite->getId()));
        $module_f->handleRequest($request);
        if ($module_f->isSubmitted() && $module_f->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'bien modifié avec succés');
            return $this->redirectToRoute('specialite');
        }
        dump($modules_spcl);
        return $this->render('admin/option/edit_module.html.twig', [
            'specialite' => $specialite,
            'modules' => $modules_spcl,
            'form_m' => $module_f->createView(),
            'current' => 9

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
            $connection = $this->em->getConnection();
            $statement = $connection->prepare("SELECT *
            FROM specialite as s
            INNER JOIN module as m
            ON m.specialite_id =  s.id 
            WHERE m.specialite_id =:id");
            $statement->bindValue('id',$specialite->getId());
            $statement->execute();
            $results = $statement->fetchAll();
            $modules = $specialite->getModules()->getValues();
            foreach($modules as $module)
            {
                $modulea = $this->r->find($module->getId());
                $this->em->remove($modulea);
                $this->em->flush();
             }
            $this->em->remove($specialite);
            $this->em->flush();
            $this->addFlash('success', 'Specialité supprimé avec succés');
        }
        return $this->redirectToRoute('specialite');
    }


}

?>