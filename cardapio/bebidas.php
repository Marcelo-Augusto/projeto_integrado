<?php
    include('connection.php');

    $scriptSQLMeal = "SELECT meal.id_meal, meal.name, meal.description, meal.src_photo, meal.enable FROM meal, category WHERE meal.id_category = category.id_category && category.name = 'Bebidas'";
    $resultMeal = $conn->query($scriptSQLMeal);
    $numero_registros=$resultMeal->num_rows;

?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Pepito's - Hamburgueria Artesanal</title>
        <link rel="shortcut icon" type="image/png" href="../Imagens/LogoCliente.png">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../js/bootstrap.min.js">
    </head>
    <body>
   
        <nav class="navbar navbar-expand-sm my-nav" style="background-color: #404040;">
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="./home.php">POPULARES</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="./acompanhamentos.php">ACOMPANHAMENTOS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="./tradicionais.php">TRADICIONAIS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="./especiais.php">ESPECIAIS</a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="./bebidas.php">BEBIDAS</a>
                  </li>
                </ul>
              </div>
							<a class="navbar-brand">
								<img src="../Imagens/LogoCliente.png" class="float-right" width="10%" height="10%" alt="Pepitos">
							</a>
            </nav>
      
      <br>
      <br>
			
        <?php
				if ($numero_registros == 0) {
			?>
				<h1>Não há registros de produtos</h1>
			<?php
				} else {
			?>
			<div class="container text-center">
				<div class= "row">
				<?php
					$prodCount = 1;
					while($vetor=$resultMeal->fetch_object()) {
						
						$scriptSQLPrice = "SELECT price.price, price.enable, price.description FROM price, meal WHERE price.id_meal = meal.id_meal && price.id_meal = ".$vetor->id_meal."";
							$resultPrice = $conn->query($scriptSQLPrice);
						
						if ($vetor->enable == 1) {
				?>
							<div class= "col-lg-3 col-md-3 mb-2">
								<div class= "card">
									<img class="card-img-top" src="../Imagens/<?php echo $vetor->src_photo?>">
									<div class="card-body">
										<h4><?php echo $vetor->name;?></h4>
										<p><?php echo $vetor->description;?></p>
										<?php
											$count = 0;
											while ($p=$resultPrice->fetch_object()) {
												if ($p->enable == 1) {
										?>
														<p><strong>
														<?php
															if (!empty($p->description)) {
																echo $p->description;?> - <?php 	
															}
														$count++;
														echo 'R$ ' . number_format($p->price, 2, ',', '.');?></strong></p>
										<?php
												}
											}
											if ($count == 0) {
												echo '<p><strong>Preço indisponível</strong></p>';
											}
										?>
									</div>
								</div>
							</div>
				<?php
					}
						else {
							$prodCount--;
						}
				?>
			<?php
						if ($prodCount % 4 == 0) {
							echo '</div><div class= "row">';
						}
						$prodCount++;
					}
			?>
						</div>
					</div>
			<?php
				}
			?>
			
			<br><br>
			<footer class="mojFooter">
				<div class="footertexto py-3">
					© 2018 Cardig. All rights reserved.
                  <img src="../Imagens/logo.png" class="float-right" width="5%" alt="Cardig">
				</div>
			</footer>			
    </body>
</html>