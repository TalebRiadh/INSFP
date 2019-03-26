<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Repository\NewsRepository;
use App\Repository\FichierRepository;
use App\Entity\FichierSearch;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Fichier;
use App\Entity\News;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FichierSearchType;

class HomeController extends AbstractController
{

     /**
     * @var NewsRepository
     */
    private $repository;

     /**
     * @var FichierRepository
     */
    private $r;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(FichierRepository $r,NewsRepository $repository,ObjectManager $em)
    {
        $this->repository = $repository;
        $this->r = $r;
        $this->em = $em;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $events = $this->repository->findlastesevents();
        $news = $this->repository->findlastesnews();
        $fichier = $this->r->findlastesfichier();

        return $this->render('home/index.html.twig', [
            'events'=>$events,
            'news'=>$news,
            'fichiers'=>$fichier
        ]);
    }
    
    
/**
     * @Route("/evenement/{slug}-{id}", name="evenement.show", requirements={"slug" : "[a-z0-9\-]*"})
     * @param News $news
     * @return Response
     */
    public function showevent(ObjectManager $em,News $news, string $slug):Response
    {
        if($news->getSlug() !== $slug){
                    return $this->redirectToRoute('home',301);
                }else{
              
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
                foreach( $result as $file){
                   $test=explode(".",$file);
                }
                  $extension[] = $test[1];
            }
            $first = $results[0];
                return $this->render('home/evenement.html.twig',[
                    'event' =>$news,
                    'first' =>$first,
                    'results' => $results,
                    'extension' =>$extension
                ]);}
            }
            


/**
     * @Route("/nouvelle/{slug}-{id}", name="news.show", requirements={"slug" : "[a-z0-9\-]*"})
     * @param News $news
     * @return Response
     */
    public function shownews(ObjectManager $em,News $news, string $slug):Response
    {
        if($news->getSlug() !== $slug){
                    return $this->redirectToRoute('home',301);
                }else{
              
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
                foreach( $result as $file){
                   $test=explode(".",$file);
                }
                  $extension[] = $test[1];
            }
            $first = $results[0];
                return $this->render('home/news.html.twig',[
                    'news' =>$news,
                    'first' =>$first,
                    'results' => $results,
                    'extension' =>$extension
                ]);}
            }

                       
  /**
     * @Route("/cours",name="fichiers.show")
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response

     */

    public function fichiers(PaginatorInterface $paginator, Request $request)
    {
        $search = new FichierSearch();
        $form = $this->createForm(FichierSearchType::class, $search);
        $form->handleRequest($request);

        $fichier = $paginator->paginate(
            $this->r->findAllVisibleQuery($search),  /* query NOT result */
            $request->query->getInt('page', 1)  /*page number*/,
            12  /*limit per page*/
        );

        return $this->render('home/fichiers.html.twig', [
            'fichier' => $fichier,
            'form' => $form->createView(),
        ]);
    }



}
