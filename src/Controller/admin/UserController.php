<?php

namespace App\Controller\admin;

use Knp\Component\Pager\PaginatorInterface;
use App\Entity\UserSearch;

use App\Form\UserSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\RegistrationType;

class UserController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(UserRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;

    }




    /**
     * @Route("/admin/user", name="admin.user.index")
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
    /*method index va permettre de recuperer l'ensemble des livres*/
    public function index(PaginatorInterface $paginator, Request $request) : Response
    {
        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);

        $user = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),  /* query NOT result */
            $request->query->getInt('page', 1)  /*page number*/,
            12  /*limit per page*/
        );

        return $this->render('Admin/user/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'current' => 1
        ]);
    }


    /**
     * @Route("/admin/user/create", name="admin.user.new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->onPrePersist();
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'bien créé avec succés');

            return $this->redirectToRoute('admin.user.index');
        }
        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'current' => 2
        ]);

    }


    /**
     * @Route("/admin/user/{id}", name="admin.user.edit",methods="GET|POST")
     * @param User $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(User $user, Request $request)
    {
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'bien modifié avec succés');
            return $this->redirectToRoute('admin.user.index');
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'current' => 1

        ]);

    }

    /**
     * @Route("/admin/user/{id}", name="admin.user.delete",methods="DELETE")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function remove(User $user, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))) {
            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('success', 'bien supprimé avec succés');

        }
        return $this->redirectToRoute('admin.user.index');

    }
}