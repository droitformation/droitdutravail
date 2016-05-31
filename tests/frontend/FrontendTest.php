<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FrontendTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testHomepage()
    {
        $this->visit('/')->see('Droit du travail.ch');
    }

    public function testJurisprudence()
    {
        $this->visit('jurisprudence')->see('Jurisprudence');

        $this->assertViewHas('arrets');
    }

    public function testContact()
    {
        $this->visit('contact')->see('Contactez-nous');
    }

    public function testColloque()
    {
        $this->visit('colloque')->see('Colloque');
    }

    public function testAuteur()
    {
        $this->visit('auteur')->see('Auteurs et contributeurs');
    }
}
