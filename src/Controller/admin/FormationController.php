<?php

namespace App\Controller\admin;

use App\Entity\Specialite;
use App\Entity\Formation;
use App\Entity\SpecialiteFormation;
use App\Form\SpecialiteType;
use App\Form\FormationType;
use App\Repository\SpecialiteRepository;
use App\Repository\FormationRepository;
use App\Repository\SpecialiteFormationRepository;
use Symfony\Component\Security\Core\User\UserInterface\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Twig\Environment;



class FormationController extends AbstractController
{


    /**
     * @var FormationRepository
     */
    private $repository;
     /**
     * @var SpecialiteRepository
     */
    private $r;

    /**
     * @var SpecialiteFormationRepository
     */
    private $rep;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(SpecialiteFormationRepository $rep,SpecialiteRepository $r,FormationRepository $repository, ObjectManager $em)
    {
        $this->r = $r;
        $this->rep = $rep;
       $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/formation",name="formation")
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response

     */

    public function index()
    {
 
            $formation = new Formation();
            $specialite = new Specialite();
            $form = $this->createForm(FormationType::class, $formation );
            $formation_f = $this->createForm(FormationType::class, $formation);
            $formations = $this->repository->findall();

    

        return $this->render('Admin/option/formation/index.html.twig', [
            'current' => 8,
            'formations' => $formations,
            'form' => $form->createView(),
            'form_f'=> $formation_f->createView()
        ]);
    }


  
  /**
     * @Route("/admin/formation/formation_ajax",name="ajout_formation",options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
    public function ajaxAction(Request $request)
{
        // createion dune formation dans la table formation
        $formation = new Formation();
        $spc = $request->request->get('spc');
        $formation->setName($spc);
        $this->em->persist($formation);
        $this->em->flush();

        $array = $request->request->get('specialite_formation');
        foreach ($array as $k => $v) {
        $formation_specialite = new SpecialiteFormation();
        $formation_specialite->setId_formation($formation->getId());
        $formation_specialite->setId_specialite($v);
        $this->em->persist($formation_specialite);
        $this->em->flush();
}
        
        $response = new Response(json_encode(array(
        'specialité' => $array
    )));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
}
  /**
     * @Route("/admin/formation/specialite_add_ajax",name="ajout_specialite",options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
    public function specialite_add_ajax(Request $request)
{
        $specialite = new Specialite();
        $formation = $this->repository->find($request->request->get('id'));
        $specialite->setName($request->request->get('add'));
        $specialite->setFormation($formation);
        $this->em->persist($specialite);
        $this->em->flush();
        $response = new Response(json_encode(array(
        'message' => 'bien ajouter',
    )));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
}

/**
     * @Route("/admin/formation/specialite_delete_ajax",name="delete_specialite",options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
    public function specialite_delete_ajax(Request $request)
{
        $specialite=$request->request->get('specialite');
        $qb = $this->em->createQueryBuilder();
            $qb->delete('App\Entity\Specialite', 'md');
            $qb->where('md.name = :specliate');
            $qb->setParameter(':specliate', $specliate);
            $qb->getQuery()->execute();
        $response = new Response(json_encode(array(
        'message' => 'bien suppprimer',
    )));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
}


    /**
     * @Route("/admin/formation/{id}", name="admin.formation.edit",methods="GET|POST")
     * @param Formation $formation
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Formation $formation, Request $request)
    {
        $form = $this->createForm(FormationType::class, $formation);
        $id_specialites_formation = $this->rep->findByExampleField($formation->getId());
        $specialites = [];

        foreach($id_specialites_formation as $id_specialite_formation){
            $specialites[] = $this->r->find($id_specialite_formation->getId_specialite());
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'bien modifié avec succés');
            return $this->redirectToRoute('formation');
        }
        return $this->render('admin/option/formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
            'current' => 8,
            'specialites' => $specialites

        ]);

    }
     /**
     * @Route("/admin/specialite_ajout_ajax", name="admin.specialite.static",options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
    public function spe_static(Request $request)
    {
        $spc_static= new Specialite();

        $spc_static->setName($request->request->get('specialite_static'));
        $this->em->persist($spc_static);
        $this->em->flush();
        $response = new Response(json_encode(array(
        'message' => 'bien ajouter',
    )));
    $response->headers->set('Content-Type', 'application/json');

    return $response;

    }
 /**
     * @Route("/admin/formation/{id}/specialites", name="admin.formation_s.edit",methods="GET|POST")
     * @param Formation $formation
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit_s(Formation $formation, Request $request)
    {
        $specialite = new Specialite();
        $specialite_f = $this->createForm(SpecialiteType::class, $specialite);

        $specialite_f->handleRequest($request);
        if ($specialite_f->isSubmitted() && $specialite_f->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'bien modifié avec succés');
            return $this->redirectToRoute('formation');
        }
        return $this->render('admin/option/formation/edit_s.html.twig', [
            'formation' => $formation,
            'form_m' => $specialite_f->createView(),
            'current' => 8

        ]);

    }
    
    /**
     * @Route("/admin/formation/{id}", name="admin.formation.delete",methods="DELETE")
     * @param Formation $formation
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function remove(Formation $formation, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $formation->getId(), $request->get('_token'))) {
            $connection = $this->em->getConnection();
            $statement = $connection->prepare("SELECT *
            FROM specialite_formation as s
            WHERE s.id_formation =:id");
            $statement->bindValue('id',$formation->getId());
            $statement->execute();
            $results = $statement->fetchAll();
            foreach($results as $result)
            {
             $specialite_f = $this->rep->find(intval($result['id']));
                $this->em->remove($specialite_f);
                $this->em->flush();
                          }

            $this->em->remove($formation);
            $this->em->flush();
            $this->addFlash('success', 'Specialité supprimé avec succés');
        }
        return $this->redirectToRoute('formation');
    }


    /**
     * @Route("/admin/specialite_formation_delete",name="specialite_formation_delete",options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
    public function specialite_formation_delete(Request $request)
{
            $specialite=$request->request->get('specialite');
             $qb = $this->em->createQueryBuilder();
            $qb->delete('App\Entity\SpecialiteFormation', 'md');
            $qb->where('md.id_specialite = :specliate');
            $qb->setParameter(':specliate', $specialite);
            $qb->getQuery()->execute();
        $response = new Response(json_encode(array(
        'message' => 'deleted',
    )));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
}


    /**
     * @Route("/admin/specialite_formation_add",name="specialite_formation_add",options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
    public function specialite_formation_add(Request $request)
{
        $formation_id = $request->request->get('formation_id');    

            $connection = $this->em->getConnection();
            $statement = $connection->prepare("SELECT id_specialite
            FROM specialite_formation as s
            WHERE s.id_formation =:id");
            $statement->bindValue('id',$formation_id);
            $statement->execute();
            $results = $statement->fetchAll();  
            $reload = false;
            /*$test= [];
                    foreach ($results as $result) {
                    $test[]= $result['id_specialite'];
                                                }*/
        $array = $request->request->get('specialite_formation');
        foreach ($array as $k => $v) { 
                       /*foreach ($test as $t => $a) { 
                            if($a === $v){

                            }
                            else {*/
                    $formation_specialite = new SpecialiteFormation();
                    $formation_specialite->setId_formation($formation_id);
                    $formation_specialite->setId_specialite($v);
                    $this->em->persist($formation_specialite);
                    $this->em->flush();
        //}
                                    }
                                            

        $response = new Response(json_encode(array(
    )));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
}


}

?>