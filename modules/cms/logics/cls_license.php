<?php
/* This file encoded by Raizlabs PHP Obfuscator http://www.raizlabs.com/software */

class License {

    public static function F8A76ED4F28C33A75F41E730A1F64DCF4() {
        $R539B96F6E9A29587A576A2AE12BC5528 = new Db();
        $R79238B88011D62B4AC14CD6B5E5E474F = array();
        $R79238B88011D62B4AC14CD6B5E5E474F = $R539B96F6E9A29587A576A2AE12BC5528->selectResult('lookup', "vLookUp_Value", "vLookUp_Name = 'vLicenceKey'");
        foreach ($R79238B88011D62B4AC14CD6B5E5E474F as $R2EC09695B315EE1B0644B431F70082AC) {
            $R679E9B9234E2062F809DBD3325D37FB6 = $R2EC09695B315EE1B0644B431F70082AC->vLookUp_Value;
        }
        return $R679E9B9234E2062F809DBD3325D37FB6;
    }
    
    public static function FB65FDD43B9A0C83B8499D74B1A31890A($password) {
        $R13326546E5001E3BF8740B618E462878   = new Db();
        // $R4002603E450F0DB8D5A7FF540344175C = $R13326546E5001E3BF8740B618E462878->execute("SELECT id FROM cms_users WHERE username = 'admin' AND password = '".mysql_real_escape_string($password)."'");
        $R4002603E450F0DB8D5A7FF540344175C = $R13326546E5001E3BF8740B618E462878->execute("SELECT id FROM cms_users WHERE username = 'admin' AND password = '".$password."'");
        $RE0D5EDB560A26D4E1BECD832EA026E32 = $R13326546E5001E3BF8740B618E462878->fetchRow($R4002603E450F0DB8D5A7FF540344175C);
        return $RE0D5EDB560A26D4E1BECD832EA026E32;
    }        
    
    public static function F03FD063C610FFF78F127C6DCC52A6524($REBBCEB7D5CE9F8309DCC3226F5DAC53B) {
        $R539B96F6E9A29587A576A2AE12BC5528   = new Db();
        $RF30E7F69195FF3C54216B048F2A3D842    =   $R539B96F6E9A29587A576A2AE12BC5528->tablePrefix;
        $R4002603E450F0DB8D5A7FF540344175C        = $R539B96F6E9A29587A576A2AE12BC5528->execute("UPDATE ".$RF30E7F69195FF3C54216B048F2A3D842."lookup SET vLookUp_Value = '" . $REBBCEB7D5CE9F8309DCC3226F5DAC53B . "' WHERE vLookUp_Name = 'vLicenceKey'");
        // $R4002603E450F0DB8D5A7FF540344175C        = $R539B96F6E9A29587A576A2AE12BC5528->execute("UPDATE ".$RF30E7F69195FF3C54216B048F2A3D842."lookup SET vLookUp_Value = '" . mysql_real_escape_string($REBBCEB7D5CE9F8309DCC3226F5DAC53B) . "' WHERE vLookUp_Name = 'vLicenceKey'");
        return true;
    }       
    
    public static function FC718EAC1D5F164063CBA5FB022329FC7($RD7A9632D7A0B3B4AC99AAFB2107A2613) {    preg_match("/^(http:\/\/)?([^\/]+)/i",$RD7A9632D7A0B3B4AC99AAFB2107A2613, $R2BC3A0F3554F7C295CD3CC4A57492121);  $RADA370F97D905F76B3C9D4E1FFBB7FFF = $R2BC3A0F3554F7C295CD3CC4A57492121[2];  $R74A7D124AAF5D989D8BDF81867C832AC = 0;  $RA7B9A383688A89B5498FC84118153069 = mb_strlen($RADA370F97D905F76B3C9D4E1FFBB7FFF);  for ($RA09FE38AF36F6839F4A75051DC7CEA25 = 0; $RA09FE38AF36F6839F4A75051DC7CEA25 < $RA7B9A383688A89B5498FC84118153069; $RA09FE38AF36F6839F4A75051DC7CEA25++) {  $RF5687F6BBE9EC10202A32FA6C037D42B = mb_substr($RADA370F97D905F76B3C9D4E1FFBB7FFF, $RA09FE38AF36F6839F4A75051DC7CEA25, 1);  if($RF5687F6BBE9EC10202A32FA6C037D42B == ".")  $R74A7D124AAF5D989D8BDF81867C832AC = $R74A7D124AAF5D989D8BDF81867C832AC + 1;  }  $R14AFFF8F3EA02262F39E2785944AAF6F = explode('.',$RD7A9632D7A0B3B4AC99AAFB2107A2613);  $R7CC58E1ED1F92A448A027FD22153E078 = substr($RADA370F97D905F76B3C9D4E1FFBB7FFF, -7);    $RF413F06AEBBCEF5E1C8B1019DEE6FE6B = "";  $R368D5A631F1B03C79555B616DDAC1F43 = array( '.com.ac','.com.ad','.com.ae','.com.af','.com.ag','.com.ai','.com.am','.com.an','.com.ao','.com.aq',  '.com.ar','.com.as','.com.at','.com.au','.com.aw','.com.ax','.com.az','.com.ar','.com.as','.com.at',  '.com.au','.com.aw','.com.uk','.com.br','.com.pl','.com.ng','.com.ve','.com.ng','.com.mx','.com.cn',  'kids.us','kids.uk');    $RF413F06AEBBCEF5E1C8B1019DEE6FE6B = in_array($R7CC58E1ED1F92A448A027FD22153E078, $R368D5A631F1B03C79555B616DDAC1F43);    if(!$RF413F06AEBBCEF5E1C8B1019DEE6FE6B) {  if(count($R14AFFF8F3EA02262F39E2785944AAF6F) == 1){  $RF877B1AAD1B2CBCDEC872ADF18E765B7 = $RADA370F97D905F76B3C9D4E1FFBB7FFF;  }else if((count($R14AFFF8F3EA02262F39E2785944AAF6F) > 1) && (mb_strlen(substr($R14AFFF8F3EA02262F39E2785944AAF6F[count($R14AFFF8F3EA02262F39E2785944AAF6F)-2],0,38)) > 2)){   preg_match("/[^\.\/]+\.[^\.\/]+$/", $RADA370F97D905F76B3C9D4E1FFBB7FFF, $R2BC3A0F3554F7C295CD3CC4A57492121);  $RF877B1AAD1B2CBCDEC872ADF18E765B7 = $R2BC3A0F3554F7C295CD3CC4A57492121[0];  }else{   preg_match("/[^\.\/]+\.[^\.\/]+\.[^\.\/]+$/", $RADA370F97D905F76B3C9D4E1FFBB7FFF, $R2BC3A0F3554F7C295CD3CC4A57492121);  $RF877B1AAD1B2CBCDEC872ADF18E765B7 = $R2BC3A0F3554F7C295CD3CC4A57492121[0];  }  }else  $RF877B1AAD1B2CBCDEC872ADF18E765B7 = $R14AFFF8F3EA02262F39E2785944AAF6F[count($R14AFFF8F3EA02262F39E2785944AAF6F)-3];    $R10870E60972CEA72E14A11D115E17EA5 = explode('.',$RF877B1AAD1B2CBCDEC872ADF18E765B7);    $RD48CAD37DBDD2B2F8253B59555EFBE03 = strtoupper(trim($R10870E60972CEA72E14A11D115E17EA5[0]));    return $RD48CAD37DBDD2B2F8253B59555EFBE03; 
    }        
    
    public static function FCE74825B5A01C99B06AF231DE0BD667D($RD7A9632D7A0B3B4AC99AAFB2107A2613) {
        $RD7A9632D7A0B3B4AC99AAFB2107A2613 = License::FC718EAC1D5F164063CBA5FB022329FC7($RD7A9632D7A0B3B4AC99AAFB2107A2613);
        $RB5719367F67DC84F064575F4E19A2606 = License::F8A76ED4F28C33A75F41E730A1F64DCF4();
        $RFDFD105B00999E2642068D5711B49D5D = substr($RD7A9632D7A0B3B4AC99AAFB2107A2613, 0, 3);
        $RA6CC906CDD1BAB99B7EB044E98D68FAE = substr($RD7A9632D7A0B3B4AC99AAFB2107A2613, -3, 3);
        $R8439A88C56A38281A17AE2CE034DB5B7 = substr($RB5719367F67DC84F064575F4E19A2606, 0, 3);
        $R254A597F43FF6E1BE7E3C0395E9409D4 = substr($RB5719367F67DC84F064575F4E19A2606, 3, 3);
        $RDE2A352768EABA0E164B92F7ACA37DEE = substr($RB5719367F67DC84F064575F4E19A2606, -3, 3);
        $R254A597F43FF6E1BE7E3C0395E9409D4 = License::FCE67EB692054EBB3F415F8AF07562D82($R254A597F43FF6E1BE7E3C0395E9409D4, 3);
        $RDE2A352768EABA0E164B92F7ACA37DEE = License::FCE67EB692054EBB3F415F8AF07562D82($RDE2A352768EABA0E164B92F7ACA37DEE, 3);
        $R705EE0B4D45EEB1BC55516EB53DF7BCE = array('A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6,              'G' => 7, 'H' => 8, 'I' => 9, 'J' => 10, 'K' => 11, 'L' => 12,              'M' => 13, 'N' => 14, 'O' => 15, 'P' => 16, 'Q' => 17, 'R' => 18,              'S' => 19, 'T' => 20, 'U' => 21, 'V' => 22, 'W' => 23, 'X' => 24,              'Y' => 25, 'Z' => 26, '1' => 1, '2' => 2, '3' => 3, '4' => 4,              '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9);
        $RA7B9A383688A89B5498FC84118153069 = mb_strlen($RD7A9632D7A0B3B4AC99AAFB2107A2613);
        $RA5694D3559F011A29A639C0B10305B51 = 0;
        for ($RA09FE38AF36F6839F4A75051DC7CEA25 = 0;
            $RA09FE38AF36F6839F4A75051DC7CEA25 < $RA7B9A383688A89B5498FC84118153069;
            $RA09FE38AF36F6839F4A75051DC7CEA25++) {
            $RF5687F6BBE9EC10202A32FA6C037D42B = mb_substr($RD7A9632D7A0B3B4AC99AAFB2107A2613, $RA09FE38AF36F6839F4A75051DC7CEA25, 1);
            $RA5694D3559F011A29A639C0B10305B51 = $RA5694D3559F011A29A639C0B10305B51 + $R705EE0B4D45EEB1BC55516EB53DF7BCE[$RF5687F6BBE9EC10202A32FA6C037D42B];
        }
    
        if($RA5694D3559F011A29A639C0B10305B51 != ($R8439A88C56A38281A17AE2CE034DB5B7 - 24))
            return false;
        else if (strcmp($RFDFD105B00999E2642068D5711B49D5D, $R254A597F43FF6E1BE7E3C0395E9409D4) != 0)
                return false;
        else if (strcmp($RA6CC906CDD1BAB99B7EB044E98D68FAE, $RDE2A352768EABA0E164B92F7ACA37DEE) != 0)
                return false;
        else
            return true;
        }

    public static function FCE67EB692054EBB3F415F8AF07562D82($R8409EAA6EC0CE2EA307354B2E150F8C2, $R68EAF33C4E51B47C7219F805B449C109) {
        $RF413F06AEBBCEF5E1C8B1019DEE6FE6B = strrev($R8409EAA6EC0CE2EA307354B2E150F8C2);
        return $RF413F06AEBBCEF5E1C8B1019DEE6FE6B;
    }

}

?>