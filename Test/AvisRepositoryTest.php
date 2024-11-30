<?php

namespace App\Test;

use App\Repository\AvisRepository;
use PHPUnit\Framework\TestCase;

class AvisRepositoryTest extends TestCase
{
    private $AvisRepository;

    protected function setUp(): void
    {
        // Création d'un mock pour AvisRepository avec uniquement la méthode `req`
        $this->AvisRepository = $this->getMockBuilder(AvisRepository::class)
            ->onlyMethods(['req'])
            ->getMock();
    }

    public function testSaveAvis()
    {
        // Données d'entrée pour le test
        $etoiles = 5;
        $nom = 'Mike';
        $commentaire = 'Excellent service !';

        // Simulation de la méthode
        $this->AvisRepository
            ->expects($this->once()) // appel de la méthode une fois
            ->method('req')
            ->with( // Vérification des arguents
                $this->equalTo("INSERT INTO avis (etoiles, nom, commentaire) VALUES (:etoiles, :nom, :commentaire)"),
                $this->equalTo([
                    'etoiles' => $etoiles,
                    'nom' => $nom,
                    'commentaire' => $commentaire
                ])
            )
            ->willReturn(true);

        // Appel de la méthode saveAvis
        $result = $this->AvisRepository->saveAvis($etoiles, $nom, $commentaire);

        // Vérification du resultat
        $this->assertTrue($result);
    }
}