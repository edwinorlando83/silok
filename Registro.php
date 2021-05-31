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
    <h2>USUARIO REGISTRO Y LOGIN </h2>
		<h4>Crear nueva cuenta</h4>
		<?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?>
		<div class="regisFrm">
			<form action="controladores/MiCuenta_Controlador.php" method="post">
				<input type="text" name="nombres" placeholder="NOMBRES" required="">
				<input type="text" name="apellidos" placeholder="APELLIDOS" required="">
				<input type="email" name="email" placeholder="EMAIL" required="">
				<input type="text" name="telefono" placeholder="TELEFONO" required="">
				<input type="password" name="password" placeholder="PASSWORD" required="">
				<input type="password" name="confirm_password" placeholder="CONFIRMA PASSWORD" required="">
				<div class="send-button">
					<input type="submit" name="signupSubmit" value="CREAR CUENTA">
				</div>
			</form>
		</div>
	</div>
    
    
<!--Inicia columna 7-->
<div class="col-sm-3 text wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
</div>
<?php include('interfaz/login_footer.php');?>