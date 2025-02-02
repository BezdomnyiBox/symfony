<?php
namespace App\Controller;

use App\Service\ChatGptService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChatGptController extends AbstractController
{
    private ChatGptService $chatGptService;

    public function __construct(ChatGptService $chatGptService)
    {
        $this->chatGptService = $chatGptService;
    }

    #[Route('/api/chat', methods: ['POST'])]
    public function chat(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $message = $data['message'] ?? '';

        if (!$message) {
            return new JsonResponse(['error' => 'Empty message'], 400);
        }

        $reply = $this->chatGptService->getChatResponse($message);
        return new JsonResponse(['reply' => $reply]);
    }
}
