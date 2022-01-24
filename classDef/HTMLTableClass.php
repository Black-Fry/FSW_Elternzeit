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
class HTMLTableClass 
{
    var $view;      //user or admin
    var $htmlString;

    /* constructor. creates table for both viewd (admin or user) 
        param 
     *      */
    function HTMLTableClass ($_view)
    {		
        $this->view =   $_view;
        $this->initTable();
    }  

    function initTable ()
    {
        $this->htmlString   =   "";
        $this->htmlString   .=   '<ul class="responsive-table">';
        
        $this->createHeader();
        
        $this->htmlString   .=  
                '</li>';
    }
    
    function createHeader ()
    {
        $this->htmlString   .=  '<li class="table-header">';
        
        switch($this->view)
        {
            case ADMIN_VIEW:
                $this->htmlString   .=  
                    '   <div class="col col-0"></div>
                        <!--<div class="col col-1">ID Familie</div>//-->
                        <div class="col col-2">Name</div>      
                        <!--<div class="col col-3">CryptoId</div>//-->
                        <div class="col col-4">Allein-erziehend</div>
                        <div class="col col-5">E-Mail 1</div>
                        <div class="col col-6">E-Mail 2</div>
                        <div class="col col-7">bisher geleistete Stunden</div>
                        <div class="col col-8">letzte Eingabe</div>';
                break;
            case USER_VIEW:
                    '   <div class="col col-1">Nummer</div>
                        <div class="col col-2">Datum</div>
                        <div class="col col-3">Stunden</div>
                        <div class="col col-4">Verabredete T&auml;tigkeit</div>
                        <div class="col col-5">Im Auftrag bzw. Rahmen der Arbeitsgruppe</div>';
                break;
            default:
        }
    }
    
    function finishTable ()
    {
        $this->htmlString   .=  '</ul>';
    }
    
    function returnHTML ()
    {   
        $this->finishTable();
        return $this->htmlString;   
    }

    /* adds row to existing table
     *  param _view: decides whether user or admin table shall be created & populated
     *  param _valueObj is either of FamilyClass (admin-View) or EinsatzClass (user-View)
     */
    function addRow ($_valueObj)
    {
        $jsID = $_valueObj->getFamID();
        //echo $jsID;
        $this->htmlString   .=     '<li class="table-row">';
       
        switch($this->view)
        {
            case ADMIN_VIEW:
                $this->htmlString   .=  '<div class="col col-0" data-label="">'
                                    .   '   <input type="checkbox" id="check_' . $jsID . '" name="check_' . $jsID . '" >'
                                    .   '</div>';
                //<div class="col col-1" data-label="ID_Fam">1</div>
                $this->htmlString   .=  '<div class="col col-2" data-label="FamNam">'
                                    .   '   <input type="text" id="FamNamID_' . $jsID . '" name="FamNamID_' . $jsID . '" size="10" value="' . $_valueObj->getFamNam() . '">'
                                    .   '</div>';     
                //<div class="col col-3" data-label="CryptoID">j7gdMH95hu7CZLss</div>
                $this->htmlString   .=  '<div class="col col-4" data-label="Single" align="Center">'
                                    .   '   <input type="checkbox" id="single_' . $jsID . ' name="single_' . $jsID;
                //aktiviere Checkbox, wenn FamObj == alleinerziehend
                if ($_valueObj->isSingle() )
                {   $this->htmlString .=  ' checked'; }
                $this->htmlString   .=  '></div>';
                
                $this->htmlString   .=  '<div class="col col-5" data-label="Mail_1">'
                                    .   '   <input type="text" id="FamMailOne_' . $jsID . '" name="FamMailOne_' . $jsID . '" size="15" value="' . $_valueObj->getFamMail(1) . '">'
                                    .   '</div>';
                $this->htmlString   .=  '<div class="col col-6" data-label="Mail_2">'
                                    .   '   <input type="text" id="FamMailTwo_' . $jsID . '" name="FamMailTwo_' . $jsID . '" size="15" value="' . $_valueObj->getFamMail(2) . '">'
                                    .   '</div>';
                $this->htmlString   .=  '<div class="col col-7" data-label="GelStunden">'
                                    //.   '<p align="center" id="geleisteteStunden_' . $jsID . '" name="geleisteteStunden_' . $jsID . '">' . $_valueObj->returnGeleisteteStunden () . '</p>'
                                    .   '   <a href="' . ROOT_URL . '/views/user.php?cryurl=' . $_valueObj->getCryptoSecret() . '" target="_blank">' . $_valueObj->returnGeleisteteStunden () . '</a>'
                                    .   '</div>';
                $this->htmlString   .=  '<div class="col col-8">'
                                    .   '   <input type="text" id="lastUserEdit_' . $jsID . '" name="lastUserEdit_' . $jsID . '" size="14" value="' . $_valueObj->getLastUserEdit() . '">'
                                    .   '</div>';
                break;
            case USER_VIEW:
                break;
            default:
        }
   
        $this->htmlString   .=      '</li>';

    }
    
    function addFinalRow ()
    {      
        switch($this->view)
        {
            case ADMIN_VIEW:
                    $this->htmlString   .=      '<li class="table-row">'
                        .   '<div class="col col-whole" data-label="newLine"><a href="">neue Zeile einfügen</a></div>'
                        .   '</li>';
                break;
            case USER_VIEW:
                break;
            default:
        }
    }
            
    
}
