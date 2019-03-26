<?php

namespace App\Controller\admin;

use App\Entity\News;
use App\Form\NewsType;

use App\Service\FileUploader;
use App\Repository\NewsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Twig\Environment;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;

class NewsController extends AbstractController
{
/**
     * @var NewsRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(NewsRepository $repository,ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }



  /**
     * @Route("/admin/news", name="admin.news.index")
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     */
    /*method index va permettre de recuperer l'ensemble des livres*/
    public function index(ObjectManager $em,PaginatorInterface $paginator,Request $request) : Response
    {
            $news = new News();
             $news = $paginator->paginate(
            $this->repository->findAllNews(),  /* query NOT result */
            $request->query->getInt('page', 1)  /*page number*/,
            12  /*limit per page*/
        );
        return $this->render('Admin/news/index.html.twig', [
            'news' => $news,
            'current' => 4,
        ]);
    }






    /**
     *
     * @Route("admin/news/create", name="admin.news.new")
     */
    public function new(Request $request)
    {
        $news = new News();
        $form = $this->createForm('App\Form\NewsType', $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $attachments = $news->getFiles();
                $news->setType('nouvelle');
            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $file = $attachment->getFile();

                    var_dump($attachment);
                    $filename = md5(uniqid()) . '.' . $file->guessExtension();

                    $file->move(
                        $this->getParameter('upload_path'),
                        $filename
                    );
                    var_dump($filename);
                    $attachment->setFile($filename);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $news->onPrePersist();
            $em->persist($news);
            $em->flush();
            return $this->redirectToRoute('admin.news.index');
        }

        return $this->render('admin/news/new.html.twig', array(
            'news' => $news,
            'form' => $form->createView(),
            "current" => 4
        ));
    }


    
    /**
     * @Route("/admin/news/{id}", name="admin.news.edit",methods="GET|POST")
     * @param News $news
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(ObjectManager $em,News $news, Request $request)
    {

        /*$form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'bien modifié avec succés');
            return $this->redirectToRoute('admin.news.index');
        }*/
                $connection = $em->getConnection();
           
            $statement = $connection->prepare("SELECT file
FROM news as n
INNER JOIN news_files as nf
    ON n.id = nf.news_id
INNER JOIN files as f
    ON f.id = nf.files_id
WHERE n.id =:id");
            $statement->bindValue('id',$news->getId());
            $statement->execute();
            $results = $statement->fetchAll();
            foreach($results as $result){
                foreach($result as $file){
                   $test=explode(".",$file);
                }
                $extension[] = $test[1];
            }
        
        return $this->render('admin/news/edit.html.twig', [
            'results' => $result,
            'current' => 4,
            'extension' =>$extension
        ]);
    }


    /**
     * @Route("/admin/news/{id}", name="admin.news.delete",methods="DELETE")
     * @param News $news
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function remove(News $news, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $news->getId(), $request->get('_token'))) {
            $this->em->remove($news);
            $this->em->flush();
            $this->addFlash('success', 'News supprimée avec succés');

        }
        return $this->redirectToRoute('admin.news.index');

    }


}
