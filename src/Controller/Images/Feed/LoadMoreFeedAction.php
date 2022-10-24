<?php

declare(strict_types=1);

namespace App\Controller\Images\Feed;

use App\Model\Images\Application\Feed\Query\GetFeedByReader\Query;
use App\Model\Images\Application\Feed\Query\GetFeedByReader\QueryHandler;
use App\Security\UserIdentity;
use App\Service\ErrorHandler;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class LoadMoreFeedAction extends AbstractController
{
    public function __construct(private readonly QueryHandler $queryHandler, private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/feed/load', name: 'app_feed_load', methods: ['GET'])]
    public function show(Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            try {
                /** @var UserIdentity $user */
                $user = $this->getUser();

                return new JsonResponse([
                    'success' => true,
                    'html' => $this->render('images/feed/_feeds.html.twig', [
                        'feed' => $this->queryHandler->fetch(
                            new Query($user->getId(), (int) $request->query->get('page'))
                        ),
                    ])->getContent(),
                ]);
            } catch (Exception $exception) {
                $this->errorHandler->handle($exception);
            }
        }
        throw $this->createNotFoundException();
    }
}
