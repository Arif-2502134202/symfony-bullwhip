<?php

namespace App\Controller;

use App\Entity\Pengambilan;
use App\Entity\Pesanan;
use App\Form\PengambilanType;
use App\Repository\PengambilanRepository;
use App\Repository\ProduksiRepository;
use App\Repository\PesananRepository;
use App\Repository\BarangRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/pengambilan')]
class PengambilanController extends AbstractController
{
    #[Route('/home', name: 'app_pengambilan_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('pengambilan/home.html.twig');
    }

    #[Route('/', name: 'app_pengambilan_index', methods: ['GET'])]
    public function index(PengambilanRepository $pengambilanRepository): Response
    {
        return $this->render('pengambilan/index.html.twig', [
            'pengambilans' => $pengambilanRepository->findAllJoin(),
        ]);
    }

    #[Route('/stock', name: 'app_pengambilan_stock', methods: ['GET'])]
    public function stock(PengambilanRepository $pengambilanRepository): Response
    {
        return $this->render('pengambilan/stock.html.twig', [
            'pengambilans' => $pengambilanRepository->findAllJoinStock(),
        ]);
    }

    #[Route('/order', name: 'app_pengambilan_order', methods: ['GET'])]
    public function order(ProduksiRepository $produksiRepository): Response
    {
        return $this->render('pengambilan/order.html.twig', [
            'pesanans' => $produksiRepository->findAllJoinProd(),
        ]);
    }


    #[Route('/new', name: 'app_pengambilan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PengambilanRepository $pengambilanRepository, PesananRepository $pesananRepository, BarangRepository $barangRepository): Response
    {
        $idpesanan = $request->query->get('id');
    
        $datapesanan = $pesananRepository->findOneBy(['id' => $idpesanan]);
        $idbarang = $datapesanan->getBarang();

        $barang = $barangRepository->findOneBy(['id' => $idbarang]);

        return $this->renderForm('pengambilan/new.html.twig', [       
            'datapesanan' => $datapesanan,
            'barang' => $barang,            
        ]);

    }

    #[Route('/submit', name: 'app_pengambilan_submit', methods: ['GET', 'POST'])]
    public function submit(Request $request, PengambilanRepository $pengambilanRepository, PesananRepository $pesananRepository, ManagerRegistry $doctrine): Response
    {
        $idpesanan = $request->query->get("idpesanan");
        $pengambil = $request->query->get("pengambil");
        $jumlahproduksi = $request->query->get("jumlahproduksi");
        $jumlah = $request->query->get("jumlah");
        
        $em = $doctrine->getManager();
        $dtpesanan = $em->getRepository(Pesanan::class)->find($idpesanan);

        //simpan data produksi
        $em = $doctrine->getManager();

        $pengambilan = new Pengambilan();
        $pengambilan->setPesanan($dtpesanan);
        $pengambilan->setPengambil($pengambil);
        $pengambilan->setJumlahProduksi($jumlahproduksi);
        $pengambilan->setJumlah($jumlah);
        
        $em->persist($pengambilan);
        $em->flush();

        return $this->redirectToRoute('app_pengambilan_order', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_pengambilan_show', methods: ['GET'])]
    public function show(Pengambilan $pengambilan): Response
    {
        return $this->render('pengambilan/show.html.twig', [
            'pengambilan' => $pengambilan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pengambilan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pengambilan $pengambilan, PengambilanRepository $pengambilanRepository): Response
    {
        $form = $this->createForm(PengambilanType::class, $pengambilan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pengambilanRepository->save($pengambilan, true);

            return $this->redirectToRoute('app_pengambilan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pengambilan/edit.html.twig', [
            'pengambilan' => $pengambilan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pengambilan_delete', methods: ['POST'])]
    public function delete(Request $request, Pengambilan $pengambilan, PengambilanRepository $pengambilanRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pengambilan->getId(), $request->request->get('_token'))) {
            $pengambilanRepository->remove($pengambilan, true);
        }

        return $this->redirectToRoute('app_pengambilan_index', [], Response::HTTP_SEE_OTHER);
    }
}
