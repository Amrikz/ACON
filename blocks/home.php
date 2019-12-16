<!--<h1 id="about">Welcome to home.</h1>-->
<form method="GET" action="account">
<p id="flex_center"><?php accountButton(1); ?></p>
</form>
<!--<img src="https://psv4.userapi.com/c848236/u516262175/docs/d4/e9b81aa4bf49/c27626e51b8fc41db3d42c3743458c9a.gif?extra=yEwMlNoqJFCEwo3FmKz00vfQfXduR4BYMrg-pTMo5Cr2SwxHF5YuE_Ov9Prefolq-DozRHJ_cLeAwiNLIDVT6ViQCzaZrmIjsCEJnlaPZPfOlkRA4Mq3HNsID1qlWUPhP30JaC53f5ppJqiz2-166g&dl=1" width="100%">-->
<h1 id='about'>Новое</h1>
	<div class="videos">
		<?php 
		require "lib/db.php";
		$query = "SELECT id,title,preview,creator,upload_date,views FROM `files` WHERE showing = 1 ORDER BY `files`.`upload_date` DESC LIMIT 10";
		$data = mysqli_query($GLOBALS['dbc'],$query);
		$info = mysqli_fetch_assoc($data);
		while ($info) {
			if (!$info['preview'] || !file_exists($info['preview'])) {
				$info['preview'] = "images\\vid_paceholder.jpg";
			}
			echo "
	        <div class='video'>
	        	<form method='GET' action='watch'>
	            <button class='videoButton' name='vid' value=".$info['id']."><img class='videoPreview' src=".$info['preview'].">
	            <h5>".$info['title']."</h5>
	            </button></form>
	            <form method='GET' action='account'>
	            <p>".accountButton($info['creator'])."</p>
	            </form>
	            <i id='homeViews'>Просмотры: ".$info['views']."</i>
	            <h6 >Загружено: ".$info['upload_date']."</h6>
	        </div>";
	        $info = mysqli_fetch_assoc($data);
		}
		?>
	</div>
<?php

//Карточки с чаем
function getCards($a = 1,$b = 1){
                require "lib/db.php";
                /*if($b == 'all'){
                    $query = "SELECT title,preview,author,creator,upload_date FROM `files` WHERE showing = 1";
                    $data = mysqli_query($dbc,$query);
                    $b = mysqli_fetch_assoc($data)['COUNT(*)'];
                }
                echo "<div class='cards'>";

                for ($i=$a; $i <=$b; $i++) { 
                    $query = "SELECT * FROM `items` WHERE id = $i";
                    $data = mysqli_query($dbc,$query);
                    $info = mysqli_fetch_assoc($data);
                    echo "
                        <div class='card'>
                            <img src=".$info['img'].">
                            <h4>".$info['zagol']."</h4>
                            <p>".$info['text']."</p>
                            <h5 class='cost'>Цена: ".$info['price']."<i class='fas fa-tenge'></i></h5>
                            <button><i class='fas fa-shopping-cart'></i><a class='btn-ens-action btn-ens-style' data-rel='fc625d4f147061'>Заказать</a></button>
                        </div>
                        ";
                    }

                echo "</div>";*/
            }

?>
