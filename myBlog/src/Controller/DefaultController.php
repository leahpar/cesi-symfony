<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/')]
    public function index()
    {
        if ($this->isGranted("ROLE_ADMIN"))
            return $this->redirectToRoute('admin_index');

        elseif ($this->isGranted("ROLE_AUTEUR"))
            return $this->redirectToRoute('post_list_me');

        elseif ($this->isGranted("IS_AUTHENTICATED_REMEMBERED"))
            return $this->redirectToRoute('post_list');

        else
            return $this->redirectToRoute('helloworld');

    }
}
