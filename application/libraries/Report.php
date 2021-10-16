<?php
    if(!defined('BASEPATH')){
        exit('No direct script access allowed');
    }

    require_once dirname(__FILE__).'/tcpdf_min/tcpdf.php';

    class Report extends TCPDF{
        public $titulo;

        public function __construct()
        {
            parent::__construct();
        }

        //Cabecera de pagina

        public function Header(){
            //fuente
            $this->SetFont('helvetica', 'B', 20);
            //Titulo
            $this->Cell(0,15, $this->titulo, 0, false, 'C', 0, '', 0, false, 'M', 'M');

        }

        //Pie de pagina
        public function Footer(){
            //Posicion a 15mm del borde inferior
            $this->SetY(-15);
            //Fuente
            $this->SetFont('helvetica', '', 8);
            //Numero de pagina
            $this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(),0, false, 'C', 0, '', false, 'T', 'M' );

        }

    }
?>