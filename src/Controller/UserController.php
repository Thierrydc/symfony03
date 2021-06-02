<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="app_user_profile")
     */
    public function profile(): Response
    {
        $user = $this->getUser();
        // dd($user);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profile/edit", name="app_user_edit")
     */
    public function edit(EntityManagerInterface $em, Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileEditType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
