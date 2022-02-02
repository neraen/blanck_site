<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name:'index')]
class IndexController extends AbstractController
{

     #[Route('/register', name:'register')]
    public function index(Request $request, ManagerRegistry $managerRegistry): Response
    {

        $entityManager = $managerRegistry->getManager();

        $userRequested = json_decode($request->getContent());
        $user = new User();
        $user->setEmail($userRequested['email']);
        $user->setPassword(hash('sha256',$userRequested['password']));
        $user->setRoles(['ROLE_USER']);
        $entityManager->persist($user);
        $entityManager->flush();


        return new Response($request->getContent());
    }
}