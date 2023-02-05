<?php

namespace App\Controller;

use App\Entity\Barang;
use App\Form\BarangType;
use App\Repository\BarangRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/barang')]
class BarangController extends AbstractController
{
    #[Route('/home', name: 'app_barang_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('barang/home.html.twig');
    }

    #[Route('/', name: 'app_barang_index', methods: ['GET'])]
    public function index(Request $request, BarangRepository $barangRepository): Response
    {
        $session = $request->getSession();

        if ($session->get('userRole') == '2'){
            return $this->render('barang/index.html.twig', [
                'barangs' => $barangRepository->findAll(),
            ]);
        } else 
        {
            return new Response('Halaman ini tidak dapat diakses');
        }
    }

    #[Route('/new', name: 'app_barang_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BarangRepository $barangRepository): Response
    {
        $barang = new Barang();
        $form = $this->createForm(BarangType::class, $barang);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $barangRepository->save($barang, true);

            return $this->redirectToRoute('app_barang_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('barang/new.html.twig', [
            'barang' => $barang,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_barang_show', methods: ['GET'])]
    public function show(Barang $barang): Response
    {
        return $this->render('barang/show.html.twig', [
            'barang' => $barang,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_barang_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Barang $barang, BarangRepository $barangRepository): Response
    {
        $form = $this->createForm(BarangType::class, $barang);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $barangRepository->save($barang, true);

            return $this->redirectToRoute('app_barang_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('barang/edit.html.twig', [
            'barang' => $barang,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_barang_delete', methods: ['POST'])]
    public function delete(Request $request, Barang $barang, BarangRepository $barangRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$barang->getId(), $request->request->get('_token'))) {
            $barangRepository->remove($barang, true);
        }

        return $this->redirectToRoute('app_barang_index', [], Response::HTTP_SEE_OTHER);
    }
}
