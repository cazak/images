<?php

declare(strict_types=1);

namespace App\Controller\Check;

use App\Controller\ErrorHandler;
use Redis;
use RedisException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CheckRedisAction extends AbstractController
{
    #[Route('/check/redis', name: 'app_redis_check', methods: ['GET'])]
    public function check(Redis $redis, ErrorHandler $errorHandler): Response
    {
        try {
            $value = $redis->sMembers('test');
            if (!$value) {
                $redis->sAdd('test', 'test');
                $value = $redis->sMembers('test');
            }

            return new Response($value[0]);
        } catch (RedisException $e) {
            $errorHandler->handle($e);

            return new Response($e->getMessage());
        }
    }
}
