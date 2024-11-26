<?php

namespace App\Controllers;
use App\Repository\BurgersRepository;
use App\Repository\TacosRepository;
use App\Repository\ViandeRepository;
use App\Repository\SauceRepository;
use App\Repository\KebabsRepository;
use App\Repository\SaladesRepository;
use App\Repository\SnackRepository;
use App\Repository\SoftRepository;
use App\Repository\VinsRepository;
use App\Repository\BieresRepository;
use App\Repository\SupplementsRepository;
use App\Repository\PizzaRepository;


class MenuController extends Controller
{
    public function index()
    {
        $BurgersRepository = new BurgersRepository();
        $burgers = $BurgersRepository->findAll();
        $TacosRepository = new TacosRepository();
        $tacos = $TacosRepository->findAll();
        $ViandeRepository = new ViandeRepository();
        $viande = $ViandeRepository->findAll();
        $SauceRepository = new SauceRepository();
        $sauce = $SauceRepository->findAll();
        $KebabsRepository = new KebabsRepository();
        $kebabs = $KebabsRepository->findAll();
        $SaladesRepository = new SaladesRepository();
        $salades = $SaladesRepository->findAll();
        $SnackRepository = new SnackRepository();
        $snack = $SnackRepository->findAll();
        $SoftRepository = new SoftRepository();
        $soft = $SoftRepository->findAll();
        $VinsRepository = new VinsRepository();
        $vins = $VinsRepository->findAll();
        $BieresRepository = new BieresRepository();
        $bieres = $BieresRepository->findAll();
        $SupplementsRepository = new SupplementsRepository();
        $supplements = $SupplementsRepository->findAll();
        $PizzaRepository = new PizzaRepository();
        $pizzas = $PizzaRepository->findAll();
        $this->render("Menu/index", [
            'burgers' => $burgers,
            'tacos' => $tacos,
            'viande' => $viande,
           'sauce' => $sauce,
            'kebabs' => $kebabs,
           'salades' => $salades,
           'snack' => $snack,
           'soft' => $soft,
            'vins' => $vins,
            'bieres' => $bieres,
            'supplements' => $supplements,
            'pizzas' => $pizzas,
        ]);
    }
}