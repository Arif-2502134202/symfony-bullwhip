<?php

namespace App\Controller;

use App\Entity\Staff;
use App\Form\LoginType;
use App\Repository\StaffRepository;
use App\Repository\RolesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/login')]
class LoginController extends AbstractController
{
    
    #[Route('/', name: 'app_login_index', methods: ['GET'])]
    public function new(): Response
    {        
        return $this->renderForm('login/index.html.twig');
    }
    
    #[Route('/submit', name: 'app_login_submit', methods: ['GET'])]   
    public function login(Request $request, StaffRepository $staffRepository, RolesRepository $rolesRepository): Response
    {   
        $email = $request->query->get("email");
        $password = $request->query->get("password");
        
        $user = $staffRepository->findOneBy(['email' => $email]);
        if (!$user) {
            return new Response('No User Data Found for : '.$email);
        }
        if ($user->getPassword() != $password){
            return new Response('Wrong Password for user: '.$email);
        }
        $name = $user->getName(); 
        $role = $user->getLevel(); 

        $roles = $rolesRepository->findOneBy(['id' => $role]);
        $roleName = $roles->getName();

        $session = $request->getSession();
        $session->set('userEmail', $email);
        $session->set('userName', $name);
        $session->set('userRole', $role);
        $session->set('roleName', $roleName);
        
        if ($role=='1'){
            return $this->render('manajer/home.html.twig');
        }
        if ($role=='2'){
            return $this->render('barang/home.html.twig');
        }
        if ($role=='3'){
            return $this->render('pengambilan/home.html.twig');
        }
        if ($role=='4'){
            return $this->render('produksi/home.html.twig');
        }
        if ($role=='5'){
            return $this->render('pesanan/home.html.twig');
        }
        
    }

    #[Route('/', name: 'app_logout_index', methods: ['GET', 'POST'])]
    public function logout(Request $request): Response
    {     
        $session = $request->getSession();
        $session->set('userEmail', ''); 
        $session->set('userName', '');  
        $session->set('userRole', '');  
        $session->set('roleName', '');  
        return $this->redirectToRoute('app_login_index', [], Response::HTTP_SEE_OTHER);       
    }

    #[Route('/home', name: 'app_home_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }
  
}
