<?php



namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\EtudiantRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formation;
use Sentiment\Analyzer;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;



#[Route('/commentaire')]
class CommentaireController extends AbstractController
{
    #[Route('/', name: 'app_commentaire_index', methods: ['GET', 'POST'])]
    public function index(CommentaireRepository $commentaireRepository, EntityManagerInterface $entityManager, ChartBuilderInterface $chartBuilder, UserRepository $usersRepository): Response
{
    $commentaire = new Commentaire();
    $form = $this->createForm(CommentaireType::class, $commentaire);
    
    $commentaires = $commentaireRepository->findAll();

    // Compter le nombre de commentaires pour chaque type de sentiment
    $positiveCount = 0;
    $negativeCount = 0;
    $neutralCount = 0;
    foreach ($commentaires as $commentaire) {
        $sentiment = $commentaire->getSentiment();
        if ($sentiment === 'pos') {
            $positiveCount++;
        } elseif ($sentiment === 'neg') {
            $negativeCount++;
        } else {
            $neutralCount++;
        }
    }

    // Calculer les pourcentages
    $total = count($commentaires);
    $positivePercentage = ($total > 0) ? ($positiveCount / $total) * 100 : 0;
    $negativePercentage = ($total > 0) ? ($negativeCount / $total) * 100 : 0;
    $neutralPercentage = ($total > 0) ? ($neutralCount / $total) * 100 : 0;

    // Créer le graphique
    $chart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
    $chart->setData([
        'labels' => ['Positive', 'Negative', 'Neutral'],
        'datasets' => [
            [
                'label' => 'Sentiments',
                'backgroundColor' => ['#36A2EB', '#FF6384', '#FFCE56'],
                'data' => [$positivePercentage, $negativePercentage, $neutralPercentage],
            ],
        ],
    ]);



    return $this->render('commentaire/Commentaire.html.twig', [
        'commentaires' => $commentaires, 
        'chart' => $chart,
        'users' => $usersRepository->findAll(),
        'form' => $form->createView(),
    ]);
}


#[Route('/new', name: 'app_commentaire_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, EtudiantRepository $etudiantRepository): Response
{           
    $commentaire = new Commentaire();
    $form = $this->createForm(CommentaireType::class, $commentaire);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Analyse de sentiment avec php-sentiment-analyzer
        $commentText = $commentaire->getCommentaire();
        $sentiment = $this->analyseSentiment($commentText);
        $commentaire->setSentiment($sentiment);

        // Récupérer l'étudiant avec l'ID par défaut 1
        $etudiant = $etudiantRepository->find(1);
        if (!$etudiant) {
            throw $this->createNotFoundException('L\'étudiant avec l\'ID 1 n\'existe pas.');
        }
        $commentaire->setEtudiant($etudiant);

        $entityManager->persist($commentaire);
        $entityManager->flush();

        return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('commentaire/Commentaire.html.twig', [
        'form' => $form->createView(),
    ]);
}


    
private function analyseSentiment(string $comment): string
{
    $analyzer = new Analyzer();
    $sentiment = $analyzer->getSentiment($comment);

    // Récupérer la catégorie de sentiment avec le score le plus élevé
    $maxSentiment = array_keys($sentiment, max($sentiment))[0];

    // Retourner la catégorie de sentiment
    return $maxSentiment;
}



    
        
    }



