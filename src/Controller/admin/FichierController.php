<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Entity\Fichier;
use App\Entity\FichierSearch;

use App\Form\FichierSearchType;
use Symfony\Component\Security\Core\User\UserInterface\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Twig\Environment;
use App\Form\FichierType;
use App\Repository\FichierRepository;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\HttpFoundation\File\Exception\FileException;


class FichierController extends AbstractController
{


    /**
     * @var FichierRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(FichierRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/fichier",name="show_fichier")
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response

     */

    public function index(PaginatorInterface $paginator, Request $request)
    {
        $search = new FichierSearch();
        $form = $this->createForm(FichierSearchType::class, $search);
        $form->handleRequest($request);
        dump($user = $this->getUser());
        if($user->getRole() == 0){
                 $fichier = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),  /* query NOT result */
            $request->query->getInt('page', 1)  /*page number*/,
            12  /*limit per page*/
             );
        }else{
                 $fichier = $paginator->paginate(
            $this->repository->findAllVisibleQuerybyprof($search,$user->getNom()),  /* query NOT result */
            $request->query->getInt('page', 1)  /*page number*/,
            12  /*limit per page*/
             );
        }
      

        return $this->render('Admin/fichier/index.html.twig', [
            'fichier' => $fichier,
            'form' => $form->createView(),
            'current' => 3
        ]);
    }

    /**
     * @Route("/admin/fichier/add", name="add_fichier")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $fichier = new Fichier();
        $user= $this->getUser();
        $form = $this->createForm(FichierType::class, $fichier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fichier->setCreatedBy($user->getNom());
            $fichier->onPrePersist();
            $this->em->persist($fichier);
            $this->em->flush();
            $this->addFlash('success', 'bien créé avec succés');

            return $this->redirectToRoute('show_fichier');
        }
        return $this->render('/admin/fichier/new.html.twig', [
            'fichier' => $fichier,
            'form' => $form->createView(),
            'current' => 3
        ]);
    }



    /**
     * @Route("/admin/fichier/{id}", name="admin.fichier.edit",methods="GET|POST")
     * @param Fichier $fichier
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Fichier $fichier, Request $request)
    {
        $form = $this->createForm(FichierType::class, $fichier);
        $fichier = new Fichier();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fichier->onPreUpdate();
            $this->em->flush();
            $this->addFlash('success', 'bien modifié avec succés');
            return $this->redirectToRoute('show_fichier');
        }

        return $this->render('admin/fichier/edit.html.twig', [
            'fichier' => $fichier,
            'form' => $form->createView(),
            'current' => 3

        ]);

    }

    /**
     * @Route("/admin/fichier/{id}", name="admin.fichier.delete",methods="DELETE")
     * @param Fichier $fichier
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function remove(Fichier $fichier, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $fichier->getId(), $request->get('_token'))) {
            $this->em->remove($fichier);
            $this->em->flush();
            $this->addFlash('success', 'Fichier supprimé avec succés');

        }
        return $this->redirectToRoute('show_fichier');

    }



}












?>