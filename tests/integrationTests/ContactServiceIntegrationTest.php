<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;

require __DIR__.'/../../src/ContactService.php';

/**
 * * @covers invalidInputException
 * @covers \ContactService
 *
 * @internal
 */
final class ContactServiceIntegrationTest extends TestCase
{
    private $contactService;

    public function __construct(string $name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->contactService = new ContactService();
    }

    // test de suppression de toute les données, nécessaire pour nettoyer la bdd de tests à la fin
    public function testDeleteAll()
    {
        $fichierDb='contacts.sqlite';
        $bdd = new PDO('sqlite:'.$fichierDb);
        $req = $bdd->prepare('INSERT INTO contact (nom, prenom)
        VALUES(?, ?)');
        $req->execute(array('arnaur', 'boris'));

        $req = $bdd->query('DELETE * from contact WHERE nom = "arnaur"');
        $res = $req->fetchAll();
        $this->assertEquals( 0, count($res)); 
    }


    public function testCreationContact()
    {
        $fichierDb='contacts.sqlite';
        $bdd = new PDO('sqlite:'.$fichierDb);
        $bdd->query('DELETE from contact');
        $req = $bdd->prepare('INSERT INTO contact (nom, prenom)
        VALUES(?, ?)');
        $req->execute(array('arnaur', 'boris'));

        $req = $bdd->query('SELECT * from contact WHERE nom = "arnaur"');
        $res = $req->fetchAll();
        $this->assertEquals( 1, count($res)); 
    }

    public function testSearchContact()
    {
    }

    public function testModifyContact()
    {
        
        $req = $bdd->query("UPDATE contacts SET nom = 'boss' ,
        prenom = 'lion' WHERE nom = 'arnaud'");
        $req->execute();

        $req = $bdd->query('SELECT * from contacts WHERE nom = "boss"');
        $res = $req->fetchAll();
        $this->assertEquals( 1, count($res));
    }

    public function testDeleteContact()
    {
    }

}
