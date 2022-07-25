<?php

declare(strict_types=1);

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


use Symfony\Component\HttpFoundation\Response;




class UserController extends AbstractApiController {



    public function registerAction(Request $request): Response
    {
        $user = new User;
        $req = json_decode($request->getContent());


        $user->setName($req->name);
        $user->setEmail($req->email);
        $user->setPassword(crypt($req->password, $req->email));
       

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
 
        return $this->json($request->getContent());
    }

    public function loginAction(Request $request): Response {
        
        $user = new User;
        $req = json_decode($request->getContent());

        $user = $this->getDoctrine()->getRepository(User::class)->findOneByEmail($req->email);

        $id = $user->getId();
        $name = $user->getName();

        if(crypt($req->password, $req->email) == $user->getPassword()) {
            return $this->json($user);
        } else {
            return new Response("can not log in");
        }
    }

    public function getUserByIdAction(int $id): Response {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $id]);
        return $this->json($user);

    }
}