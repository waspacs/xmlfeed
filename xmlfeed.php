<?php

$tumUrunlerDizi = json_decode (file_get_contents('./products.json'), true);				//products.json dosyasındaki ürünleri bir diziye aktar
$xml_dosya = new SimpleXMLElement('<?xml version="1.0"?><products></products>');

$cevirmeTur = 0;																		//Çevirme 

foreach($tumUrunlerDizi as $tekUrun) {													//tumUrunlerDizi dizisindeki her bir ürün için
	$urunBaslik = $xml_dosya->addChild("product");										//bir alt "başlık" oluştur
	foreach($tekUrun as $bilgiTur => $bilgiDeger)										//Ürünün her bilgisinin türünü ve değerini bir değişkene ata
	$urunBaslik->addChild("$bilgiTur",htmlspecialchars("$bilgiDeger"));					//oluşturulan başlığın içine ürünü ekle				

 } 
 $xml_dosya->asXML('./urunler.xml');													//sonucu ./urunler.xml dosyasına kaydet



//Yukarıdaki kod girdi olarak products.json dosyasını kullanıp veri isimlerini değiştirmeden çevirme işlemini gerçekleştirir.

//Aşağıdaki kod cevirmeTur değişkenine göre xml dosyasındaki veri isimlerinde değişiklik yapar.

function veriIsmiDegistir($eskiIsim, $yeniIsim, $degistirilecekMetin){										//Verilen veri ismini verilen metinde değiştirir.
	$veriIsmi1 = "<" . $eskiIsim . ">";																		//<eskiIsim> olacak şekilde bir değişken oluştur
	$yeniVeriIsmi1 = "<" . $yeniIsim . ">";																	//<yeniIsim> olacak şekilde bir değişken oluştur
	$veriIsmi2 = "</" . $eskiIsim . ">";																	//</eskiIsim> olacak şekilde bir değişken oluştur
	$yeniVeriIsmi2 = "</" . $yeniIsim . ">";																//</yeniIsim> olacak şekilde bir değişken oluştur
	$degistirilmisMetin = str_replace($veriIsmi1, $yeniVeriIsmi1, $degistirilecekMetin);					//<eskiIsim>'i <yeniIsim> ile değiştir
	$degistirilmisMetin = str_replace($veriIsmi2, $yeniVeriIsmi2, $degistirilmisMetin);						//</eskiIsim>'i </yeniIsim> ile değiştir
	return $degistirilmisMetin;
}

$cevirmeTur = "cimri";																	//Çevirilecek şemayı belirtir. Gerektiğinde seçenekler arttırılabilir.

if($cevirmeTur == "cimri"){																//İstenen format cimri ise
	$urunlerXml = file_get_contents('./urunler.xml');									//urunler.xml dosyasını yükle
	$cimriXml = veriIsmiDegistir("name","title", $urunlerXml);							//name veri ismini title olarak değiştir
	$cimriXml = veriIsmiDegistir("category","categories", $cimriXml);					//category veri ismini categories olarak değiştir
	
	file_put_contents("./cimri.xml", $cimriXml);										//Elde edilen dosyayı ./cimri.xml dosyasına kaydet
}
 
?>