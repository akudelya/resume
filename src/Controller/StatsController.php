<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StatsController extends AbstractController
{
    #[Route('/stats', name: 'stats')]
    public function stats(EntityManagerInterface $entityManager): Response
    {
        $qb = $entityManager->createQueryBuilder();
        $qb->select('r.position, AVG(rtc.rating) avg_rating')
            ->from('App\Entity\Resume', 'r')
            ->leftJoin('App\Entity\ResumeToCompany', 'rtc', 'WITH', 'r = rtc.resume')
            ->groupBy('r.id')
            ->orderBy('avg_rating', 'DESC');
        $q = $qb->getQuery();
        $res = $q->getResult();
        $resumes = [];
        foreach ($res as $row) {
            $resumes[] = $row;
        }
        return $this->render('stats.html.twig', ['resumes' => $resumes]);
    }
}