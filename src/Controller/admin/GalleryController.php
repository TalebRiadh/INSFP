<?php

namespace App\Controller\admin;

use App\Entity\Gallery;
use App\Repository\GalleryRepository;
use Symfony\Component\Security\Core\User\UserInterface\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Twig\Environment;
use App\Form\GalleryType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class GalleryController extends AbstractController
{


    /**
     * @var GalleryRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(GalleryRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/gallery",name="show_gallery")
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response

     */

    public function index(PaginatorInterface $paginator, Request $request)
    {   $gallery = new Gallery();
        $gallery = $paginator->paginate(
            $this->repository->findAllVisibleQuery(),  /* query NOT result */
            $request->query->getInt('page', 1)  /*page number*/,
            12  /*limit per page*/
        );

        return $this->render('Admin/gallery/index.html.twig', [
            'gallery' => $gallery,
            'current' => 6
        ]);
    }
    /**
     * @Route("/admin/gallery/view",name="show_view")
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
 public function generalView()
    {  
        $gallery = $this->repository->findAll();

        return $this->render('Admin/gallery/view.html.twig', [
            'gallery' => $gallery,
            'current' => 6
        ]);
    }
    /**
     * @Route("/admin/gallery/add", name="add_image")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $gallery->onPrePersist();
            $this->em->persist($gallery);
            $this->em->flush();
            $this->addFlash('success', 'bien créé avec succés');

            return $this->redirectToRoute('show_gallery');
        }
        return $this->render('/admin/gallery/new.html.twig', [
            'gallery' => $gallery,
            'form' => $form->createView(),
            'current' => 6
        ]);
    }


    

    /**
     * @Route("/admin/gallery/{id}", name="admin.gallery.delete",methods="DELETE")
     * @param Gallery $gallery
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function remove(Gallery $gallery, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $gallery->getId(), $request->get('_token'))) {
            $this->em->remove($gallery);
            $this->em->flush();
            $this->addFlash('success', 'image supprimé avec succés');

        }
        return $this->redirectToRoute('show_gallery');

    }



}












?>