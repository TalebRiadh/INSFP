<?php

namespace App\Controller\admin;

use App\Entity\Message;
use App\Form\MessageType;

use App\Service\FileUploader;
use App\Repository\MessageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Twig\Environment;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;

class MessageController extends AbstractController
{
/**
     * @var NewsRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(MessageRepository $repository,ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }



  /**
     * @Route("/admin/message", name="admin.message.index")
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
    /*method index va permettre de recuperer l'ensemble des livres*/
    public function index(Request $request) 
    {
        $user = $this->getUser();
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
            $message->setMFrom($user->getEmail());
            $message->onPrePersist();
          $this->em->persist($message);
            $this->em->flush();
            $this->addFlash('success', 'Message Envoyé');
    }
        $results=$this->repository->findByExampleField($user->getEmail());
    return $this->render('admin/message/index.html.twig', [
                'results' => $results,
                'message' => $message,
                'form' => $form->createView(),
                'current' => 7
            ]);
    }




}
