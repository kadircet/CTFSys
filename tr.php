<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

$lang = array();

$lang['team'] = array();
	$lteam = &$lang['team'];
	$lteam[0] = "Takim adi boşluk iceremez";
	$lteam[1] = "Mail adresi boşluk iceremez";
	$lteam[2] = "Istek gonderdiginizde kotu seyler oldu,bence tekrar dene";
	$lteam[3] = "Bu takim adi ve mail adresi kullanilmakta";
	$lteam[4] = "Giris Adi/Sifre uyumlu degil,tekrar dene";
	$lteam[5] = "Bu hesap mail adresi dogrulamasi bekliyor";
	$lteam[6] = "HackMETU CTF Kayit";
	$lteam[7] = "<html><body><pre>";
	$lteam[7].= "Selam \${name},\nBu mail adresinden kayit istegini aldik,hadi hayirlisi :D.\n";
	$lteam[7].= "Eger boyle bir istekte bulunmadiysaniz,bu maili onemsemeyin.\n\nAksi halde, hesabinizi aktive etmek icin ";
	$lteam[7].= "<a href='http://ctf.0xdeffbeef.com/?action=verify&name=\${name}&verify=\${verify}'>buraya bas</a> ya da alttaki linki ziyaret ediniz:\n";
	$lteam[7].= "http://ctf.0xdeffbeef.com/?action=verify&name=\${name}&verify=\${verify}";
	$lteam[7].= "\n\nHackMETU CTF Takimi tarafindan gonderildi,\nSize iyi bir yarisma gecirmenizi dileriz,yolunuz acik olsun :)\n";
	$lteam[7].= "\n\nKullanici Adi: \${name}\n";
	$lteam[7].= "Sifre: \${pass}\n";
	$lteam[7].= "\n0xdeffbeef\nwe hack, you watch\nlove <3\n";
	$lteam[7].= "</pre></body></html>";
	$lteam[8] = "Gecersiz takim ID";
	$lteam[9] = "Bu mail adresine sahip takim bulunmamaktadir";
	$lteam[10] = "Bu isme sahip takim bulunmamaktadir";
	$lteam[] = "Uygun olmayan dogrulama kodu";
	
$lang['base'] = array();
	$base = &$lang['base'];
	$base[0] = "Takim Adi/Dogrulama Kodu kombinasyonu gecersizdir";
	$base[1] = "Bu takim onceden dogrulanmistir";
	$base[2] = "Hesabiniz dogrulanmistir";

$lang['header'] = array();
	$header = &$lang['header'];
	$header[0] = "Ana sayfa";
	$header[1] = "Gorevler";
	$header[2] = "Puan Tablosu";
	$header[3] = "Hakkında";
	$header[4] = "Kayit";
	$header[5] = "Oturum Acmak";
	$header[6] = "Giris";
	$header[7] = "Sifrenizi mi Unuttunuz?";
	$header[8] = "Hos Geldiniz";
	$header[] = "Ayarlar Degistirme";
	$header[] = "Cikis";
	$header[] = "Mesaj Panosu";
	
$lang['register'] = array();
	$register = &$lang['register'];
	$register[] = "Takimlar maksimum 3 kisiliktir,daha fazla uye ekleyemezsiniz";
	$register[] = "Kayit esnasinda bir sorunla karsilasildi,lutfen daha sonra tekrar deneyiniz";
	$register[] = "Kaydiniz basariyla yapilmistir,mail adresinize bir email gönderilmistir";
	$register[] = "Butun bosluklari doldurunuz";
	$register[] = "Takim adi";
	$register[] = "Email <font color='red'>*</font>";
	$register[] = "Sifre";
	$register[] = "Uyeler";
	$register[] = "Uye Ekle";
	$register[] = "Kayit";
	$register[10] = "<font color='red'>*</font> Eger bir problem olusursa,takiminiza bu mail adresi ile ulasilacaktir";
	
$lang['profile'] = array();
	$profile = &$lang['profile'];
	$profile[] = "Puanlar";
	$profile[] = "Uyeler";
	$profile[] = "Sifre Degistir<font color='red'>*</font>";
	$profile[] = "Yeni Sifre Giriniz";
	$profile[] = "<font color='red'>*</font> Eger sifrenizi degistirmeyecekseniz, bu bolgeyi bos birakin";
	$profile[] = "Simdiki sifreniz";
	$profile[] = "Simdiki sifrenizi giriniz";
	$profile[] = "Guncelleme";
	$profile[] = "Yanlis Sifre";
	$profile[] = "Profiliniz basariyla guncellenmistir.";
	
$lang['forgot'] = array();
	$forgot = &$lang['forgot'];
	$forgot[] = "Email";
	$forgot[] = "Sifirlama mailini gonder";
	$forgot[] = "HackMETU Sifre sifirlama maili";
	$forgot[3] = "<html><body><pre>";
	$forgot[3].= "Selam \${name},\nBu mail adresi icin sifre sifirlama maili istegini aldik.\n";
	$forgot[3].= "Eger boyle bir istekte bulunmamissaniz bu maili onemsemeyin.\n\nAksi halde, sifre sifirlamak icin ";
	$forgot[3].= "<a href='http://ctf.0xdeffbeef.com/forgot.php?action=forgot&name=\${name}&verify=\${verify}'>buraya basin</a> ya da asagidaki linki ziyaret ediniz:\n";
	$forgot[3].= "http://ctf.0xdeffbeef.com/forgot.php?action=forgot&name=\${name}&verify=\${verify}";
	$forgot[3].= "\n\nHackMETU CTF Takimi tarafindan gonderilmistir,\nSize iyi bir yarisma gecirmenizi dileriz,yolunuz acik olsun :)\n";
	$forgot[3].= "\n0xdeffbeef\nwe hack, you watch\nlove <3\n";
	$forgot[3].= "</pre></body></html>";
	$forgot[] = "Sifre sifirlama";
	$forgot[5] = "Mail adresinize sifre sifirlamak icin mail gonderilmistir";
	$forgot[6] = "Sifreniz basariyla sifirlanmistir";

$lang['board'] = array();
	$board = &$lang['board'];
	$board[] = "HackMETU CTF Puan Tablosu";
	$board[] = "Takim Adi";
	$board[] = "Puanlar";

$lang['msg'] = array();
	$msgboard = &$lang['msg'];
	$msgboard[] = "HackMETU CTF Mesaj Panosu";
	$msgboard[] = "Takim Adi";
	$msgboard[] = "Mesaj";
	$msgboard[] = "Bu deli mesajlasmaya katilmak icin,giris yap ";

	
$lang['task'] = array();
	$ltask = &$lang['task'];
	$ltask[] = "Gecersiz soru ID ";
	$ltask[] = "Cozum yollayabilmek icin giris yapsana be ";
	$ltask[] = "Bayrak";
	$ltask[] = "itCan{}b3_4ny7h1nG";
	$ltask[] = "Tam Isabet!";
	$ltask[] = "Hicbir babayigit daha cozemedi";
	$ltask[] = "Tebrikler!! Cozumunuz Dogrudur!";
	$ltask[] = "Vayy Bee !Yanlis yerlerde dolaniyon!! Sen beni mi zorluyon ???";
?>
