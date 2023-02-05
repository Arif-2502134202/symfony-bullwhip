<?php

namespace App\Controller;

use App\Entity\Pesanan;
use App\Entity\Barang;
use App\Form\PesananType;
use App\Form\BarangType;
use App\Repository\PesananRepository;
use App\Repository\BarangRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pesanan')]
class PesananController extends AbstractController
{
    #[Route('/home', name: 'app_pesanan_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('pesanan/home.html.twig');
    }

    #[Route('/', name: 'app_pesanan_index', methods: ['GET'])]
    public function index(PesananRepository $pesananRepository): Response
    {
        $pesanan = new Pesanan();
        return $this->render('pesanan/index.html.twig', [    
            'pesanans' => $pesananRepository->findAllJoin(),
        ]);
    }

    #[Route('/barang', name: 'app_pesanan_barang', methods: ['GET', 'POST'])]
    public function barang(Request $request, BarangRepository $barangRepository): Response
    {
        $barang = new Barang();
        $form = $this->createForm(BarangType::class, $barang);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $barangRepository->save($barang, true);

            return $this->redirectToRoute('app_pesanan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pesanan/barang.html.twig', [
            'barang' => $barang,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_pesanan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PesananRepository $pesananRepository): Response
    {
        $pesanan = new Pesanan();
        $form = $this->createForm(PesananType::class, $pesanan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pesananRepository->save($pesanan, true);

            return $this->redirectToRoute('app_pesanan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pesanan/new.html.twig', [
            'pesanan' => $pesanan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pesanan_show', methods: ['GET'])]
    public function show(Pesanan $pesanan): Response
    {
        return $this->render('pesanan/show.html.twig', [
            'pesanan' => $pesanan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pesanan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pesanan $pesanan, PesananRepository $pesananRepository): Response
    {
        $form = $this->createForm(PesananType::class, $pesanan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pesananRepository->save($pesanan, true);

            return $this->redirectToRoute('app_pesanan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pesanan/edit.html.twig', [
            'pesanan' => $pesanan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pesanan_delete', methods: ['POST'])]
    public function delete(Request $request, Pesanan $pesanan, PesananRepository $pesananRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pesanan->getId(), $request->request->get('_token'))) {
            $pesananRepository->remove($pesanan, true);
        }

        return $this->redirectToRoute('app_pesanan_index', [], Response::HTTP_SEE_OTHER);
    }

}
