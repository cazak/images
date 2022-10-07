<?php

declare(strict_types=1);

namespace App\Controller\Images\Feed;

use App\Model\Images\Application\Feed\Query\GetFeedByReader\Query;
use App\Model\Images\Application\Feed\Query\GetFeedByReader\QueryHandler;
use App\Service\ErrorHandler;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetFeedAction extends AbstractController
{
    public function __construct(private readonly QueryHandler $queryHandler, private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/feed', name: 'app_feed', methods: ['GET'])]
    public function show(): Response
    {
        try {
            return $this->render('images/feed/show.html.twig', [
                'feed' => $this->queryHandler->fetch(new Query($this->getUser()->getId(), 1)),
                'maxPage' => $this->queryHandler->getFeedMaxPage($this->getUser()->getId()),
            ]);
        } catch (Exception $exception) {
            $this->errorHandler->handle($exception);
            throw $this->createNotFoundException();
        }
    }
}
