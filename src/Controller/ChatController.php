<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Professeur;
use App\Repository\ChatRepository;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ChatController extends AbstractController
{
    #[Route('/chat/{id}', name: 'app_chat')]
    public function index(
        int $id,
        ChatRepository $chatRepository, 
        ProfesseurRepository $professeurRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $staticUser = $professeurRepository->find(1);
        $forum = $entityManager->getReference('App\Entity\Forum', $id);
        $chat = $chatRepository->findByForum($id);
        
        return $this->render('back/tablesChat.html.twig', [
            'chat' => $chat,
            'staticUser' => $staticUser,
            'forum' => $forum
        ]);
    }

    #[Route('/chat/{forumId}/send', name: 'app_chat_send', methods: ['POST'])]
    public function send(
        int $forumId,
        Request $request, 
        EntityManagerInterface $entityManager,
        ProfesseurRepository $professeurRepository
    ): Response {
        $content = trim($request->request->get('message'));
        
        if (!empty($content)) {
            $staticUser = $professeurRepository->find(1);
            $forum = $entityManager->getReference('App\Entity\Forum', $forumId);
            
            $message = new Chat();
            $message->setContent($content);
            $message->setCreatedAt(new \DateTime());
            $message->setIdProfesseur($staticUser);
            $message->setForum($forum);

            $entityManager->persist($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chat', ['id' => $forumId]);
    }
}
