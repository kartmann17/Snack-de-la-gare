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
        $alias = "burgers";
        $burgers = $BurgersRepository->findAll($alias);

        $TacosRepository = new TacosRepository();
        $alias = "Tacos";
        $tacos = $TacosRepository->findAll($alias);

        $ViandeRepository = new ViandeRepository();
        $alias = "Viandes";
        $viande = $ViandeRepository->findAll($alias);

        $SauceRepository = new SauceRepository();
        $alias = "Sauces";
        $sauce = $SauceRepository->findAll($alias);

        $KebabsRepository = new KebabsRepository();
        $alias = "kebabs";
        $kebabs = $KebabsRepository->findAll($alias);

        $SaladesRepository = new SaladesRepository();
        $alias = "Nos_Salades";
        $salades = $SaladesRepository->findAll($alias);

        $SnackRepository = new SnackRepository();
        $alias = "Nos_Snacks";
        $snack = $SnackRepository->findAll($alias);

        $SoftRepository = new SoftRepository();
        $alias = "Nos_Soft";
        $soft = $SoftRepository->findAll($alias);

        $VinsRepository = new VinsRepository();
        $alias = "Nos_Vins";
        $vins = $VinsRepository->findAll($alias);

        $BieresRepository = new BieresRepository();
        $alias = "Nos_Bieres";
        $bieres = $BieresRepository->findAll($alias);

        $SupplementsRepository = new SupplementsRepository();
        $alias = "Supplements";
        $supplements = $SupplementsRepository->findAll($alias);

        $PizzaRepository = new PizzaRepository();
        $alias = "Pizza";
        $pizzas = $PizzaRepository->findAll($alias);

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
