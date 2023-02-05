<?php

namespace App\Controller;

use App\Entity\Produksi;
use App\Entity\Pesanan;

use App\Form\ProduksiType;
use App\Repository\ProduksiRepository;
use App\Repository\PesananRepository;
use App\Repository\BarangRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/produksi')]
class ProduksiController extends AbstractController
{
    #[Route('/', name: 'app_produksi_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('produksi/home.html.twig');
        
    }

    #[Route('/produksi', name: 'app_produksi_index', methods: ['GET'])]
    public function index(ProduksiRepository $produksiRepository): Response
    {
        return $this->render('produksi/index.html.twig', [
            'produksis' => $produksiRepository->findAllJoin(),
        ]);
        
    }

    #[Route('/order', name: 'app_produksi_order', methods: ['GET'])]
    public function order(PesananRepository $pesananRepository): Response
    {
        return $this->render('produksi/order.html.twig', [
            'pesanans' => $pesananRepository->findAllJoin(),
        ]);
    }

    #[Route('/new', name: 'app_produksi_new', methods: ['GET'])]
    public function new(Request $request, ProduksiRepository $produksiRepository, PesananRepository $pesananRepository, BarangRepository $barangRepository): Response
    {
        $idpesanan = $request->query->get('id');
    
        $datapesanan = $pesananRepository->findOneBy(['id' => $idpesanan]);
        $idbarang = $datapesanan->getBarang();

        $barang = $barangRepository->findOneBy(['id' => $idbarang]);

        return $this->renderForm('produksi/new.html.twig', [       
            'datapesanan' => $datapesanan,
            'barang' => $barang,            
        ]);
    }

    #[Route('/submit', name: 'app_produksi_submit', methods: ['GET', 'POST'])]
    public function submit(Request $request, ProduksiRepository $produksiRepository, PesananRepository $pesananRepository, BarangRepository $barangRepository, ManagerRegistry $doctrine): Response
    {
        $idpesanan = $request->query->get("idpesanan");
        $jumlah = $request->query->get("jumlah");
        $leadtime = $request->query->get("leadtime");

        //update data pemesanan
        $em = $doctrine->getManager();
        $dtpesanan = $em->getRepository(Pesanan::class)->find($idpesanan);

        if (!$dtpesanan) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        $dtpesanan->setProses(1);
        $em->flush();

        //simpan data produksi
        $em = $doctrine->getManager();

        $produksi = new Produksi();
        $produksi->setPesanan($dtpesanan);
        $produksi->setJumlah($jumlah);
        $produksi->setLeadtime($leadtime);
        $em->persist($produksi);
        $em->flush();

        return $this->redirectToRoute('app_produksi_order', [], Response::HTTP_SEE_OTHER);
    }
 
    #[Route('/{id}', name: 'app_produksi_show', methods: ['GET'])]
    public function show(Produksi $produksi): Response
    {
        return $this->render('produksi/show.html.twig', [
            'produksi' => $produksi,
        ]);
    }


    #[Route('/{id}', name: 'app_produksi_delete', methods: ['POST'])]
    public function delete(Request $request, Produksi $produksi, ProduksiRepository $produksiRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produksi->getId(), $request->request->get('_token'))) {
            $produksiRepository->remove($produksi, true);
        }

        return $this->redirectToRoute('app_produksi_index', [], Response::HTTP_SEE_OTHER);
    }
}
