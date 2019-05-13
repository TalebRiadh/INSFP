<?php

namespace App\Controller\admin;

use App\Entity\Specialite;
use App\Entity\Formation;
use App\Form\SpecialiteType;
use App\Form\FormationType;
use App\Repository\SpecialiteRepository;
use App\Repository\FormationRepository;

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
     * @var ObjectManager
     */
    private $em;

    public function __construct(SpecialiteRepository $r,FormationRepository $repository, ObjectManager $em)
    {
        $this->r = $r;
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
            foreach ($formations as $formation) {
            foreach ($formation->getSpecialites() as $specialite) {
        }
    }

        return $this->render('Admin/option/formation/index.html.twig', [
            'current' => 3,
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
        $formation = new Formation();
        /* get last id */
        $spc = $request->request->get('spc');

        $formation->setName($spc);
        $this->em->persist($formation);
        $this->em->flush();
        $response = new Response(json_encode(array(
        'formation' => $spc
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
     * @param Formation $Formation
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Formation $Formation, Request $request)
    {
        $form = $this->createForm(FormationType::class, $Formation);
        $formation = new Formation();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'bien modifié avec succés');
            return $this->redirectToRoute('formation');
        }

        return $this->render('admin/option/formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
            'current' => 3

        ]);

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
            'current' => 3

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
            $this->em->remove($formation);
            $this->em->flush();
            $this->addFlash('success', 'Specialité supprimé avec succés');
        }
        return $this->redirectToRoute('formation');
    }


}

?>