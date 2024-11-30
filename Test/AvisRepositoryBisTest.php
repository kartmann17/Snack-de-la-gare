<?php

namespace App\Test;

use App\Repository\AvisRepository;
use PHPUnit\Framework\TestCase;

class AvisRepositoryBisTest extends TestCase
{
    private $AvisRepository;

    protected function setUp(): void
    {
        // Mock du repository AvisRepository
        $this->AvisRepository = $this->getMockBuilder(AvisRepository::class)
                                     ->onlyMethods(['req'])
                                     ->getMock();
    }

    public function testValideAvisReturnsData()
    {
        // Données simulées de la base de données
        $mockData = [
            ['id' => 1, 'etoiles' => 5, 'nom' => 'John Doe', 'commentaire' => 'Excellent!', 'valide' => 1],
            ['id' => 2, 'etoiles' => 4, 'nom' => 'Jane Doe', 'commentaire' => 'Very good!', 'valide' => 1],
        ];

        // Configuration du mock
        $this->AvisRepository->method('req')
                             ->willReturn(new class($mockData) {
                                 private $data;
                                 public function __construct($data) { $this->data = $data; }
                                 public function fetchAll() { return $this->data; }
                             });

        // Appel de la méthode
        $result = $this->AvisRepository->valideAvis(1);

        // Assertions
        $this->assertIsArray($result, 'Le résultat doit être un tableau.');
        $this->assertCount(2, $result, 'Le tableau doit contenir 2 éléments.');
        $this->assertEquals($mockData, $result, 'Les données retournées doivent correspondre aux données simulées.');
    }

    public function testValideAvisReturnsEmptyArray()
    {
        // Configuration du mock pour retourner aucun résultat
        $this->AvisRepository->method('req')
                             ->willReturn(new class([]) {
                                 private $data;
                                 public function __construct($data) { $this->data = $data; }
                                 public function fetchAll() { return $this->data; }
                             });

        // Appel de la méthode
        $result = $this->AvisRepository->valideAvis(0);

        // Assertions
        $this->assertIsArray($result, 'Le résultat doit être un tableau.');
        $this->assertCount(0, $result, 'Le tableau doit être vide lorsque aucun avis n\'est trouvé.');
    }
}