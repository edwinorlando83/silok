<?php
session_start();
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
if(!empty($sessData['estado']['msg'])){
    $statusMsg = $sessData['estado']['msg'];
    $statusMsgType = $sessData['estado']['type'];
    unset($_SESSION['sessData']['estado']);
}
include('interfaz/login_header.php');
?>
<div class="col-sm-3 r-form-1-box wow fadeInLeft animated" style="visibility: visible; animation-name: fadeInLeft;"></div>

<div class="col-sm-6 r-form-1-box wow fadeInLeft animated" style="visibility: visible; animation-name: fadeInLeft;">
                    
    <h2><b>REGISTRO Y LOGIN </b></h2>
        <?php
			if(!empty($sessData['userLoggedIn']) && !empty($sessData['userID'])){
				include 'bd/bd_Usuarios.php';
				$user = new User();
				$conditions['where'] = array(
					'id' => $sessData['userID'],
				);
				$conditions['return_type'] = 'single';
				$userData = $user->getRows($conditions);
		?>
        <h2>Bienvenido <?php echo $userData['nombres']; ?>!</h2>
        <a href="controladores/MiCuenta_Controlador.php?logoutSubmit=1" class="logout">Cerrar Sesion</a>
		<div class="regisFrm">
			<p><b>Nombres: </b><?php echo $userData['nombres'].' '.$userData['apellidos']; ?></p>
            <p><b>Email: </b><?php echo $userData['email']; ?></p>
            <p><b>Telefono: </b><?php echo $userData['telefono']; ?></p>
		</div>
        <?php }else{ ?>
		<h2>Acceder a mi Cuenta</h2>
        <?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?>
		<div class="regisFrm">
			<form action="controladores/MiCuenta_Controlador.php" method="post">
				<input type="email" name="email" placeholder="EMAIL" required="">
				<input type="password" name="password" placeholder="PASSWORD" required="">
				<div class="send-button">
					<input type="submit" name="loginSubmit" value="INICIAR SESSION">
				</div>
				<a href="EnviarPassword.php">Reiniciar Contraseña?</a>
			</form>
            <p>No tienes una cuenta? <a href="Registro.php">Registrarme</a></p>
		</div>
        <?php } ?>

</div>   
<!--Inicia columna 7-->
<div class="col-sm-3 text wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
</div>
<?php include('interfaz/login_footer.php');?>