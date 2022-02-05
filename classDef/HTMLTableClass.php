<?php

include './FamilyClass.php';

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of FamClass
 *
 * @author Micha
 */
abstract class HTMLTableClass 
{
    public $view;      //user or admin
    public $htmlString;

    function HTMLTableClass ()
    {	echo ("HTMLTableClass ()");    }   

//    abstract protected function initTable ();
    
//    abstract protected function createHeader ();
    
    /* adds row to existing table
     *  param _view: decides whether user or admin table shall be created & populated
     *  param _valueObj is either of FamilyClass (admin-View) or EinsatzClass (user-View)
     */
//    abstract protected function addRow ($_valueObj);

//    abstract protected function addFinalRow ();    

//    abstract protected function finishTable ();
    
//    abstract protected function returnHTML ();
    
}
