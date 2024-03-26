<?php
require_once("../utils/gen.php");
require_once "../utils/db.php";
require_once("../utils/auth.php");

redirectLogged("home.php");

gen_head("New Portfolio");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"]) && isset($_POST["senha"])) {
	$email = $_POST["email"];
	$senha = $_POST["senha"];

	$exists = $db->prepare("SELECT * FROM person WHERE email = ? AND password = ?");
	$exists->bind_param("ss", $email, $senha); // TODO: Implement password hashing
	$exists->execute();
	$result = $exists->get_result();

	if ($result->num_rows !== 0) {
		setAuthCookie($result->fetch_assoc()["id"]);
		header('Location: home.php');
	} else {
		$error = "Usuário ou senha inválidos";
	}
}
?>

<section class="flex flex-col items-center justify-center w-full min-h-screen gap-4">
	<form method="POST" class="space-y-8 *:space-y-2 w-full max-w-[calc(512px+1rem)] px-4">
		<h1 class="title">LOGIN</h1>

		<div>
			<h1 class="title required">Email</h1>
			<input id="email" type="text" class="input" placeholder="johndoe@exemplo.com" name="email" required>
		</div>

		<div>
			<h1 class="title required">Senha</h1>
			<input id="senha" type="password" class="input" placeholder="•••••••••••••••••" name="senha" required>
		</div>

		<button class="w-full btn">Entrar</button>

		<?php echo "<p class='mx-auto text-red-500 w-fit'>$error</p>"; ?>
	</form>

	<p>Ainda não tem uma conta? <a href="registrar.php" class="link">Registre-se</a></p>
</section>

<script>
	<?php
	if ($_SERVER["REQUEST_METHOD"] !== "POST" && !isset($_POST["nome"]) && !isset($_POST["nomeusuario"]) && !isset($_POST["email"]) && !isset($_POST["senha"]) && !isset($_POST["senha-repetida"])) {
		echo "</script>";
		exit;
	}
	?>

	window.onload = (e) => {
		document.getElementById("email").value = "<?php echo $_POST["email"] ?>";
		document.getElementById("senha").value = "<?php echo $_POST["senha"] ?>";
	}
</script>