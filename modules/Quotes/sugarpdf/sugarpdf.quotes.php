<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/


require_once('include/Sugarpdf/Sugarpdf.php');

class QuotesSugarpdfQuotes extends Sugarpdf{
    var $aclAction = "detail";

    // Defines the boundaries of the header image
    const MAX_WIDTH = 348;
    const MAX_HEIGHT = 60;
    const DPI = 500;

    /**
     * Override
     */
    function process(){
        $this->preDisplay();
        $this->display();
        $this->buildFileName();
    }
    /**
     * Custom header for Quotes
     */
    public function Header() {
        $ormargins = $this->getOriginalMargins();
        $headerfont = $this->getHeaderFont();
        $headerdata = $this->getHeaderData();

        if (($headerdata['logo']) AND ($headerdata['logo'] != K_BLANK_IMAGE)) {
            $logo = K_PATH_CUSTOM_IMAGES.$headerdata['logo'];
            $imsize = @getimagesize($logo);
            if ($imsize === FALSE) {
                // encode spaces on filename
                $logo = str_replace(' ', '%20', $logo);
                $imsize = @getimagesize($logo);
                if ($imsize === FALSE) {
                    $logo = K_PATH_IMAGES.$headerdata['logo'];
                    $imsize = @getimagesize($logo);
                }
            }
            if ( $imsize ) {
                // Print of the logo
                // The way that the 3rd and 4th parameters work in Image() is weird. I have added a case to check if
                // w and h are set as well as resize = true so that we can get what fitbox was supposed to do.
                // w and h are used as boundary sizes in this case.
                $this->Image($logo, $this->GetX(), $this->getHeaderMargin(), self::MAX_WIDTH, self::MAX_HEIGHT, '', '', '', true, self::DPI);
            }

        }
        // This table split the header in 3 parts of equal width. The last part (on the right) contain the header text.
        $table[0]["logo"]="";
        $table[0]["blank"]="";
        $table[0]["data"]="<div><font face=\"".$headerfont[0]."\" size=\"".($headerfont[2]+1)."\"><b>".$headerdata['title']."</b></font></div>".$headerdata['string'];
        $options = array(
            "isheader"=>false,
        );
        $this->SetTextColor(0, 0, 0);
        // header string
        $this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
        // Start overwrite
        $this->writeHTMLTable($table, false, $options);
    }

    function display(){
        //turn off all error reporting so that PHP warnings don't munge the PDF code
        error_reporting(0);
        set_time_limit(1800);

        //Create new page
        $this->AddPage();
        $this->SetFont(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN);
        $this->Ln();
    }

    /**
     * To be override
     */
    function buildFileName(){

    }
    /**
     * This method draw an horizontal line with a quotes specific style.
     */
    protected function drawLine(){
        $this->SetLineStyle(array('width' => 0.85 / $this->getScaleFactor(), 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(220, 220, 220)));
        $this->MultiCell(0, 0, '', 'T', 0, 'C');
    }
}