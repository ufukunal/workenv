<?php
require_once 'config.php';
require_once 'top.php';
@session_start();
$defaultC='';
?>
        
        <table width="100%" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td style="padding: 10px 0px 10px 5px; width: 12%; min-width: 200px" valign="top">
                    <div style="border: 1px solid #b0b0b0; background-color: White; padding: 10px; -moz-border-radius: 4px;
                        border-radius: 4px;">
                        <h1 class="anasayfa_baslik" style="margin: 0px; padding-bottom: 4px">
                            Tüm Kampanyalar</h1>
                        <table style="border-collapse: collapse; border: none; width: 100%" cellpadding="3" cellspacing="3">
                            
                                    <tbody><tr>
                                        <td style="width: 14px">
                                            <img src="gareport_files/klasor.gif">
                                        </td>
                                        <td>
                                                <?php
                                                
$dapi=new Dapi();
$sql="select distinct campaign from adwords where account='$_SESSION[username]' group by campaign";
$res=$dapi->select($sql);
$defaultC=isset($_GET['campaign'])?$_GET['campaign']:$res[0]['campaign'];
foreach ($res as $r) {
//	echo $r['campaigns'];
echo '<a style="color: #0066cc" href="campaigns.php?campaign='.$r['campaign'].'">'.$r['campaign'].'</a>';
                                            
}
                                                ?>
                                        </td>
                                    </tr>
                                
                        </tbody></table>
                    </div>
                </td>
                <td style="width: 85%; vertical-align: top">
                    
    <table width="100%">
        <tbody><tr>
            <td style="padding: 10px 5px 10px 5px;" valign="top">
                <div style="border: 1px solid #b0b0b0; background-color: White; padding: 10px; -moz-border-radius: 4px;
                    border-radius: 4px;">
                    <div style="height: 50px">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tbody><tr>
                                <td style="vertical-align: top">
                                    <span class="anasayfa_baslik"></span><br>
                                    <strong id="ctl00_ContentPlaceHolder1_stTarihBilgisi" style="color: Red; font-weight: bold">
                                    </strong>
                                </td>
                                <td>
                                    <div style="border: 1px solid #b0b0b0; background-color: White; padding: 2px; -moz-border-radius: 4px;
                                        border-radius: 4px; float: right">
                                        <div style="padding: 5px; width: 324px; height: 27px;">
                                            <div style="width: 319px">
                                                <div style="width: 237px; float: left">
                                                    <div id="divDropDown" style="border: solid 1px Gray; height: 23px; width: 100%">
                                                        <select name="ctl00$ContentPlaceHolder1$ddlSecim" id="ctl00_ContentPlaceHolder1_ddlSecim" style="width:100%;border: none; height: 100%">
	<option selected="selected" value="BG">Bugün</option>
	<option value="D">Dün</option>
	<option value="S7G">Son 7 Gün</option>
	<option value="BA">Bu Ay</option>
	<option value="GA">Geçen Ay</option>
	<option value="SDG">Son 90 Gün</option>
	<option value="OA">Özel Tarih Aralığı</option>

</select>
                                                    </div>
                                                    <div id="divTarihAraligi" style="background-color: White; text-align: center; float: left;
                                                        display: none; padding: 5px; border: solid 1px gray; border-top: none; width: 226px;">
                                                        <input name="ctl00$ContentPlaceHolder1$txtBaslangicTarihi" id="ctl00_ContentPlaceHolder1_txtBaslangicTarihi" class="abc hasDatepicker" style="height:21px;width:100px;" type="text">
                                                        <input name="ctl00$ContentPlaceHolder1$txtBitisTarihi" id="ctl00_ContentPlaceHolder1_txtBitisTarihi" class="abc hasDatepicker" style="height:21px;width:100px;" type="text">
                                                    </div>
                                                </div>
                                                <div style="width: 72px; float: right">
                                                    <input name="ctl00$ContentPlaceHolder1$Button3" value="Getir" id="ctl00_ContentPlaceHolder1_Button3" class="inputButon yenileButon" type="submit">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody></table>
                    </div>
                    <div style="width: 99%">
                    </div>
                    <div id="ddcolortabsalt" class="ddcolortabsalt">
                        <ul>
                            <li><a href="campaigns.php" title="Anahtar Kelimeler" style="background-color: #00592c;
                                color: #fff"><span>Anahtar Kelimeler</span></a></li>
                            <li><a href="gorsel.php" title="Gorsel Ag" ><span>Gorsel Ag</span></a></li>
                        </ul>
                    </div>
                    <div id="ctl00_ContentPlaceHolder1_divKampanyalar">
                        <div id="basic-modal">
                            <input id="btnAnahtarKelimeEkle" style="width: 190px; display: none;" class="inputButon ekleButon" onclick="AnahtarKelimeEklePopupAc('PK')" value="Yeni Anahtar Kelime Ekle" type="button">
                            <input name="ctl00$ContentPlaceHolder1$btnWord" value="Word'e aktar" id="ctl00_ContentPlaceHolder1_btnWord" class="inputButon wordButon" type="submit">
                            <input name="ctl00$ContentPlaceHolder1$btnExcel" value="Excel'e aktar" id="ctl00_ContentPlaceHolder1_btnExcel" class="inputButon excelButon" type="submit">
                            <input id="btnPrint" class="inputButon printButon" onclick="CallPrint()" value="Yazdır" type="button">
                        </div>
                    </div>
                    <div id="ctl00_ContentPlaceHolder1_divAnahtarKelimeIcerik" style="background-color: #f9f9f9;">
                        <table width="100%" cellpadding="3" cellspacing="0">
                            <thead class="tabloBaslik">
                                <tr>
                                    <th class="sol">
                                        Anahtar Kelime
                                    </th>
                                    <th class="sol">
                                        Kampanya
                                    </th>
                                    <th class="sag">
                                        Max. TBM
                                    </th>
                                    <th class="sag">
                                        Tıklamalar
                                    </th>
                                    <th class="sag">
                                        Gösterim
                                    </th>
                                    <th class="sag">
                                        Ort.TBM
                                    </th>
                                    <th class="sag">
                                        Maliyet
                                    </th>
                                    
                                </tr>
                            </thead>
                            <tbody class="tabloIcerik">
<?php 
$sql="select * from adwords where account='$_SESSION[username]' and campaign='$defaultC'";
//echo $sql;
$res=$dapi->select($sql);
foreach ($res as $row) {

 echo "<tr>
                                            <td style='width:100px;'>
                                        $row[keyword]
                                            </td>
                                            <td class='sol'>
						    <span style='vertical-align: middle; color: #0066cc' class='sol'>$row[campaign]</span>
                                            </td>
                                            <td class='sag maxTBM' onclick='SetKeywordMTBM(1123196476)'>
                                                
                                              $row[maxCPC] <span style='font-size:7pt'> TL</span>
                                            </td>
                                            <td class='sag'>
                                                
                                            $row[clicks]  
                                            </td>
                                            <td class='sag'>
                                          $row[impressions] 
                                                
                                            </td>
                                            <td class='sag'>
                                            
                                               $row[avgCPC]<span class='para'> TL</span>
                                            </td>
                                            <td class='sag'>
                                                $row[cost]<span class='para'> TL</span>
                                            </td>
                                           
                                        </tr>

					";
}
?>

                            </tbody>
                            <tfoot class="tabloFooter">
                                <tr>
                                    <td class="merkez durum" style="border-left: 1px solid #CCCCCC">
                                        Toplam:
                                    </td>
                                    <td class="sol" colspan="4">
                                        <span id="ctl00_ContentPlaceHolder1_lblAnahtarKelime"></span><br>
                                    </td>
                                    <td class="sag">
                                        <span id="ctl00_ContentPlaceHolder1_lblMTBM"></span><span style="font-size:7pt"> TL</span>
                                    </td>
                                    <td class="sag">
                                        <span id="ctl00_ContentPlaceHolder1_lblTiklamaOrani"></span>
                                    </td>
                                    <td class="sag">
                                        <span id="ctl00_ContentPlaceHolder1_lblTiklama">0</span>
                                    </td>
                                    <td class="sag">
                                        <span id="ctl00_ContentPlaceHolder1_lblGosterim">0</span>
                                    </td>
                                    <td class="sag">
                                        <span id="ctl00_ContentPlaceHolder1_lblOTBM"></span><span style="font-size:7pt"> TL</span>
                                    </td>
                                    <td class="sag">
                                        <span id="ctl00_ContentPlaceHolder1_lblMaliyet">0,00</span><span style="font-size:7pt"> TL</span>
                                    </td>
                                    <td class="merkez">
                                        <span id="ctl00_ContentPlaceHolder1_lblKalitePuan"></span>
                                    </td>
                                    <td class="sag">
                                        -
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div style="text-align: left; width: 100%; padding-top: 5px; padding-bottom: 8px">
                    </div>
                    <div id="divNegatifAnahtarKelimeler" style="width: 50%; display: none">
                        <div id="basic-modal" style="width: 100%; padding: 5px 0px 5px 0px">
                            <input style="display: none;" id="btnNegatifKelimeEkle" class="inputButon ekleButon" onclick="AnahtarKelimeEklePopupAc('NK')" value="Yeni Ekle" type="button">
                            
                            
                            <input id="Button7" class="inputButon printButon" onclick="CallPrintNegatif()" value="Yazdır" type="button">
                        </div>
                        <div id="ctl00_ContentPlaceHolder1_divNegatifKelimelerIcerik">
                            <table width="100%" cellpadding="3" cellspacing="0">
                                <thead class="tabloBaslik">
                                    <tr>
                                        <th class="solKenar sol">
                                            Negatif Anahtar Kelime
                                        </th>
                                        <th class="sol">
                                            Kampanya
                                        </th>
                                        <th class="sol" colspan="2">
                                            Reklam Grubu
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="tabloIcerik" id="tblNegatif">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody></table>
