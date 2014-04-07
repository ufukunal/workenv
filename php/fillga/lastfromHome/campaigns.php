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
                                                
$sql="select distinct campaign from adwords where customerId='$_SESSION[customerId]' group by campaign";
$res=$dapi->select($sql);
if($_SESSION['username']!='admin'){
$defaultC=isset($_GET['campaign'])?$_GET['campaign']:$res[0]['campaign'];
foreach ($res as $r) {
//	echo $r['campaigns'];
	echo '<a style="color: #0066cc" href="campaigns.php?campaign='.$r['campaign'].'">'.$r['campaign'].'</a>';
}}
                                                ?>
<script type='text/javascript' >
function loadTarih(){

	var tar=document.getElementById('tarihoptions').value;
	location.href="campaigns.php?tar="+tar+"&campaign=<?php echo $defaultC; ?>";
	//alert(tar);
}
</script>
        
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
                                                        <select name="ctl00$ContentPlaceHolder1$ddlSecim" id="tarihoptions" style="width:100%;border: none; height: 100%">
	<option value="1" <?php if(isset($_GET['tar'])){if($_GET['tar']==1)echo 'selected';} ?> >Dün</option>
	<option value="7" <?php if(isset($_GET['tar'])){if($_GET['tar']==7)echo 'selected';} ?> >Son 7 Gün</option>
	<option value="30" <?php if(isset($_GET['tar'])){if($_GET['tar']==30)echo 'selected';} ?> >Son 30 Gün</option>
	<option value="90" <?php if(isset($_GET['tar'])){if($_GET['tar']==90)echo 'selected';} ?> >Son 90 Gün</option>

</select>
                                                    </div>
                                                </div>
                                                <div style="width: 72px; float: right">
                                                    <input name="getirname" value="Getir" id="getirid" class="inputButon yenileButon" type="button" onclick="loadTarih()">

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
$tararalik="";
if(isset($_GET['tar'])){

$finishDate=date('Ymd',strtotime('yesterday'));
//echo "finis:$finishDate";
$startDate=date('Ymd',strtotime("-$_GET[tar] days"));
	//echo 'start:'.$startDate;
$tararalik=" and (tarih >= $startDate and tarih<= $finishDate)";

}else{
$finishDate=date('Ymd',strtotime('yesterday'));
//echo "finis:$finishDate";
$startDate=date('Ymd',strtotime("yesterday"));

$tararalik=" and (tarih >= $startDate and tarih<= $finishDate)";
}
$sql="select sum(clicks) as tclicks, sum(cost) as tcost, sum(impressions) as timp,campaign, keyword from adwords where customerId='$_SESSION[customerId]' and campaign='$defaultC' $tararalik group by keyword ";
//echo $sql;
$res=$dapi->select($sql);
//print_r($res);
foreach ($res as $row) {

 echo "<tr>
                                            <td style='width:100px;'>
                                        $row[keyword]
                                            </td>
                                            <td class='sol'>
						    <span style='vertical-align: middle; color: #0066cc' class='sol'>$row[campaign]</span>
                                            </td>
                                            <td class='sag'>
                                                
                                            $row[tclicks]  
                                            </td>
                                            <td class='sag'>
                                          $row[timp] 
                                                
                                            </td>
                                            <td class='sag'>
                                            
                                            </td>
                                            <td class='sag'>
                                                $row[tcost]<span class='para'> TL</span>
                                            </td>
                                           
                                        </tr>

					";
}
?>

                            </tbody>
                            <tfoot class="tabloFooter">
<?php
$toplam=$dapi->select("select sum(cost) as tcost,sum(clicks) as tclicks,sum(impressions) as timp from hesap where customerId=$_SESSION[customerId] $tararalik");
?>
                                <tr>
                                    <td class="merkez durum" style="border-left: 1px solid #CCCCCC">
                                        Toplam:
                                    </td>
                                    <td class="sag">
                                        <span id="ctl00_ContentPlaceHolder1_lblMTBM"></span><span style="font-size:7pt"> </span>
                                    </td>
                                    <td class="sag">
                                        <span id="ctl00_ContentPlaceHolder1_lblTiklama"><?php
                                        echo $toplam[0]["tclicks"];
                                        ?></span>
                                    </td>
                                    <td class="sag">
                                        <span id="ctl00_ContentPlaceHolder1_lblGosterim"><?php
                                        echo $toplam[0]["timp"];
                                        ?></span>
                                    </td>
                                    <td class="sag">
                                        <span id="ctl00_ContentPlaceHolder1_lblOTBM"></span><span style="font-size:7pt"> </span>
                                    </td>
                                    <td class="sag">
                                        <span id="ctl00_ContentPlaceHolder1_lblMaliyet"><?php
                                        echo $toplam[0]["tcost"];
                                        ?></span><span style="font-size:7pt"> TL</span>
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
