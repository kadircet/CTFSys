<?php
//Author: Kadir CETINKAYA - breakv0id@0xdeffbeef

require_once("base.php");

if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case "verify":
			$id = 0;
			$status = 0;
			$name = $_GET['name'];
			$code = $_GET['verify'];
			
			try
			{
				$sql = "SELECT `id`, `status` FROM `teams` WHERE `name`=? AND `verification`=?";
				$stmt = $db->prepare($sql);
				$stmt->bind_param("ss", $name, $code);
				$stmt->bind_result($id, $status);
				$stmt->execute();
				$stmt->store_result();
			
				if($stmt->num_rows!==1)
					throw new Exception($base[0]);
			
				$stmt->fetch();
		
				if($status===1)
					throw new Exception($base[1]);
				
				$salt = base64_encode(generateSalt());
				$sql = "UPDATE `teams` SET `status`=1, `verification`=? WHERE `id` = ?";
				$stmt = $db->prepare($sql);
				$stmt->bind_param("si", $salt, $id);
				$stmt->execute();
			
				$success .= $base[2]."\n";
				$_SESSION['success'] = $success;
			}
			catch(Exception $e)
			{
				$error .= $e->getMessage()."\n";
				die($error);
			}
			break;
	}
	$_SESSION['error'] = $error;
	header("Location: index.php");
}
else
{
?>
<div style="height:5px;"></div>

<div class="well" style="text-align:center;">
	<p>
	    <img src="http://144.122.7.254/hackmetu/images/hackmetu_color.png" style="width:800px" /><br/>
		Etkinliğimizin temel amacı, bilgisayar mühendisliği ve diğer bölümlerden kendini
		güvenlik alanında geliştirmek isteyen her öğrencinin, ODTÜ 'den yeni bilgiler ve
		yetenekler kazanarak eğlenmiş bir biçimde ayrılmasıdır. Ayrıca bu etkinlik öğrencileri
		bilişim sistemleri güvenliğinin temelleri ve problem çözme gibi konularda bilinçlendirmeyi
		ve cesaretlendirmeyi amaçlamaktadır. Bu sene birincisi düzenlenecek olan
		etkinliğimizde katılımcılardan 30 saat süresince etkinlik başında açıklanacak olan
		güvenlik temalı sorulara çözümler geliştirmeleri istenmektedir.
	</p>
</div>

<div class="well" style="text-align:center;">
	<p>
		<li>Her takim en fazla 1(bir) isim altinda yarisabilir.</li>
		<li>Katilimcilarin takimlar halinde veya bireysel olarak yarisabilirler.</li>
		<li>Bir takimdaki uye sayisi 3(uc)'u gecemez, yarisma suresi dusunuldugunde en az 2(iki) kisi olunmasi onerilmektedir.</li>
		<li>Problemler hakkindaki sorularinizi yarisma alanindaki gorevlilere direk olarak veya sistem uzerinden sorabilirsiniz.</li>
		<li>Yarisma sistemindeki buglari bildirmek odullendirilecek, somurmek ise diskalifiyeye sebep olacaktir.</li>
		<li>Katilimcilari rahatsiz etmek diskalifiye sebebidir.</li>
		<li>Yarismada web, pwnable, reverse engineering ve cryptography kategorilerinden sorular olacaktir.</li>
		<li>IEEE ODTU katilimci limiti hakkini sakli tutar ve bu limitin asilmasi durumunda, secim tarihe gore degil, gonderdiginiz cv'lere ve hatta gerekirse online bir mini ctf'e gore yapilacaktir.</li>
	</p>
</div>

<div class="well" style="text-align:center;">
	<p>
		SPONSORLARIMIZ
		<center>
   	  <a href="http://sahibinden.com/"><img height="80" src="http://www.logoeps.net/wp-content/uploads/2013/06/sahibinden.com-logo.jpg"></a>
   	  <a href="http://labrisnetworks.com/"><img heigt="80" src="http://hackmetu.com/images/QYClhGN.png"></a>
   	  <a href="http://ceng.metu.edu.tr/"><img height="80" width="80" src="http://www.ceng.metu.edu.tr/lib/plugins/arctic/images/logo.shadow.png"></a>
   	  <a href="http://odtuteknokent.com.tr/"><img height="80" src="http://hackmetu.com/images/tekno.png"></a>
   	  <a href="http://www.computer.org/"><img height="80" width="200" src="http://computer.ieeesiliconvalley.org/wp-content/uploads/sites/2/2014/01/vancouver_1.gif"></a>
   	  </center>
	</p>
</div>

<?php
}
require_once("footer.php");

?>
