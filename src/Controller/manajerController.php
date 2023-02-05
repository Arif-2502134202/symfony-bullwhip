<?php

namespace App\Controller;

use App\Entity\Produksi;
use App\Entity\Pesanan;

use App\Form\ProduksiType;
use App\Repository\ProduksiRepository;
use App\Repository\BarangRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/manajer')]
class manajerController extends AbstractController
{
    #[Route('/home', name: 'app_manajer_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('manajer/home.html.twig');
        
    }

    #[Route('/', name: 'app_manajer_index', methods: ['GET'])]
    public function index(Request $request, ProduksiRepository $produksiRepository, ManagerRegistry $doctrine): Response
    {
        $session = $request->getSession();

        if ($session->get('userRole') == '1'){
            return $this->render('manajer/index.html.twig', [
                'barangs' => $produksiRepository->findAllJoinBarang(),
            ]);
        } else 
        {
            return new Response('Halaman ini tidak dapat diakses');
        }
        
    }

    #[Route('/grafik', name: 'app_manajer_grafik', methods: ['GET'])]
    public function grafik(ChartBuilderInterface $chartBuilder, ProduksiRepository $produksiRepository, ManagerRegistry $doctrine): Response
    {
        $labels = [];
        $datasets = [];

        $repo = $produksiRepository->findAllJoinBarang();

        foreach($repo as $data){
            $labels[] = $data['nama'];
        }
        foreach($repo as $data){
            $datasets1[] = $data['bullwhip'];
            $datasets2[] = $data['parameter'];
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'BE',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $datasets1,
                ],
                [
                    'label' => 'Parameter',
                    'backgroundColor' => 'rgb(56,84,153)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $datasets2,
                ],
            ],    
            
        ]);

        $chart->setOptions([
            'indexAxis' => 'y',
        ]);

        return $this->render('manajer/grafik.html.twig', [
            'labels' =>$labels,
            'chart' => $chart,
        ]);

    }

    
}
