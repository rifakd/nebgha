<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class VideoCallController extends AbstractController implements MessageComponentInterface
{
    private $rooms = [];
    private $clients = [];

    #[Route('/video_call/{id}', name: 'video_call_join', methods: ['GET'])]
    public function joinCourse(int $id, SessionInterface $session): Response
    {
        // Get or initialize the list of participants for this call
        $participants = $session->get("video_call_$id", []);

        // Add the current user to the participants list
        $currentUserId = uniqid(); // Generate a temporary unique user ID
        $participants[$currentUserId] = [
            'id' => $currentUserId,
            'joinedAt' => new \DateTime(),
        ];

        // Update the session with the new participants list
        $session->set("video_call_$id", $participants);

        return $this->render('cours/meet.html.twig', [
            'callId' => $id,
            'participants' => $participants,
            'currentUserId' => $currentUserId,
        ]);
    }

    #[Route('/video_call/{id}/leave', name: 'video_call_leave', methods: ['POST'])]
    public function leaveCourse(int $id, Request $request, SessionInterface $session): Response
    {
        $currentUserId = $request->get('userId');

        // Remove the user from the participants list
        $participants = $session->get("video_call_$id", []);
        unset($participants[$currentUserId]);
        $session->set("video_call_$id", $participants);

        // Redirect to a safe page after leaving
        return $this->redirectToRoute('app_cour_listeCour');  // ou une autre route de votre choix
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $query = [];
        parse_str($conn->httpRequest->getUri()->getQuery(), $query);
        
        $roomId = $query['roomId'];
        $userId = $query['userId'];
        
        // Store client connection
        $this->clients[$userId] = $conn;
        
        // Add user to room
        if (!isset($this->rooms[$roomId])) {
            $this->rooms[$roomId] = [];
        }
        $this->rooms[$roomId][$userId] = $conn;
        
        // Notify other users in the room
        foreach ($this->rooms[$roomId] as $participantId => $participant) {
            if ($participantId !== $userId) {
                $participant->send(json_encode([
                    'type' => 'userJoined',
                    'userId' => $userId
                ]));
            }
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg);
        if (isset($this->clients[$data->to])) {
            $this->clients[$data->to]->send($msg);
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Remove user from rooms and clients
        foreach ($this->rooms as $roomId => $room) {
            foreach ($room as $userId => $client) {
                if ($client === $conn) {
                    unset($this->rooms[$roomId][$userId]);
                    unset($this->clients[$userId]);
                    
                    // Notify other users in the room
                    foreach ($this->rooms[$roomId] as $participant) {
                        $participant->send(json_encode([
                            'type' => 'userLeft',
                            'userId' => $userId
                        ]));
                    }
                }
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}
