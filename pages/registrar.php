<?php
require_once("../utils/gen.php");
require_once "../utils/db.php";

gen_head("New Portfolio");

$error = "";

function sanitizeString($str) {
	$sanitized = preg_replace('/[^a-z0-9]/i', '', $str);
	$sanitized = strtolower($sanitized);

	return $sanitized;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nome"]) && isset($_POST["nomeusuario"]) && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["senha-repetida"])) {
	$nome = $_POST["nome"];
	$nomeusuario = sanitizeString($_POST["nomeusuario"]);
	$email = $_POST["email"];
	$senha = $_POST["senha"];
	$senharepetida = $_POST["senha-repetida"];

	$usernamequery = $db->prepare("SELECT * FROM person WHERE username = ?");
	$usernamequery->bind_param("s", $nomeusuario);
	$usernamequery->execute();
	$usernameresult = $usernamequery->get_result();

	$emailquery = $db->prepare("SELECT * FROM person WHERE email = ?");
	$emailquery->bind_param("s", $email);
	$emailquery->execute();
	$emailresult = $emailquery->get_result();

	if ($usernameresult->num_rows !== 0) {
		$error = "Esse nome de usuário já existe.";
	} else if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
		$error = "Este email não é valido";
	} else if ($emailresult->num_rows !== 0) {
		$error = "Esse email já existe.";
	} else if ($senha !== $senharepetida) {
		$error = "As senhas não coincidem.";
	} else {
		$stmt = $db->prepare("INSERT INTO person (fullname, username, email, password) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("ssss", $nome, $nomeusuario, $email, $senha); // TODO: Implement password hashing
		$stmt->execute();
		//header('Location: login.php');
	}
}
?>

<section class="flex flex-col items-center justify-center w-full min-h-screen gap-4">
	<form method="POST" class="space-y-8 *:space-y-2 w-full max-w-[calc(512px+1rem)] px-4">
		<h1 class="title">REGISTRAR</h1>

		<div>
			<h1 class="title required">Nome</h1>
			<input id="nome" type="text" class="input" placeholder="John Doe" name="nome" required>
		</div>

		<div>
			<h1 class="title">Nome de Usuário</h1>
			<input id="nomeusuario" type="text" class="input" placeholder="johndoe123" name="nomeusuario" required>
		</div>


		<div>
			<h1 class="title required">Email</h1>
			<input id="email" type="text" class="input" placeholder="johndoe@exemplo.com" name="email" required>
		</div>

		<div>
			<h1 class="title required">Senha</h1>
			<input id="senha" type="password" class="input" placeholder="•••••••••••••••••" name="senha" required>
		</div>

		<div>
			<h1 class="title required">Repita a Senha</h1>
			<input id="senharepetida" type="password" class="input" placeholder="•••••••••••••••••" name="senha-repetida" required>
		</div>

		<button class="w-full btn">Criar</button>

		<?php echo "<p class='mx-auto text-red-500 w-fit'>$error</p>"; ?>
	</form>
</section>

<script>
	const form = document.getElementsByTagName("form")[0];
	const inputNome = document.getElementById("nome");
	const inputNomeUsuario = document.getElementById("nomeusuario");

	const random = "<?php echo rand(); ?>";

	let lastUsername = "";

	inputNome.oninput = (e) => {
		let toUsername = e.target.value.toLowerCase().replaceAll(/[^a-z0-9]/gi, "") + random;

		if (inputNomeUsuario.value === lastUsername || inputNomeUsuario.value === "") {
			inputNomeUsuario.value = toUsername;
			inputNomeUsuario.placeholder = toUsername;
		}

		if (inputNomeUsuario.value === random) {
			toUsername = '';
			inputNomeUsuario.value = toUsername;
			inputNomeUsuario.placeholder = 'johndoe123';
		}

		if (e.target.value === '') {
			toUsername = '';
			inputNomeUsuario.placeholder = 'johndoe123';
		}

		lastUsername = toUsername;
	};

	inputNomeUsuario.oninput = (e) => {
		e.target.value = e.target.value.toLowerCase().replaceAll(/[^a-z0-9]/gi, "");
	}

	inputNomeUsuario.onblur = (e) => {
		if (e.target.value === "" && lastUsername !== "") e.target.value = e.target.placeholder;
	}

	<?php
	if ($_SERVER["REQUEST_METHOD"] !== "POST" && !isset($_POST["nome"]) && !isset($_POST["nomeusuario"]) && !isset($_POST["email"]) && !isset($_POST["senha"]) && !isset($_POST["senha-repetida"])) {
		echo "</script>";
		exit;
	}
	?>

	window.onload = (e) => {
		let name = "<?php echo $_POST["nome"] ?>";
		let username = "<?php echo sanitizeString($_POST["nomeusuario"]) ?>";
		let email = "<?php echo $_POST["email"] ?>";
		let senha = "<?php echo $_POST["senha"] ?>";
		let senharepetida = "<?php echo $_POST["senha-repetida"] ?>";

		document.getElementById("nome").value = name;
		document.getElementById("nomeusuario").value = username;
		document.getElementById("email").value = email;
		document.getElementById("senha").value = senha;
		document.getElementById("senharepetida").value = senharepetida;

		lastUsername = inputNomeUsuario.placeholder = name.toLowerCase().replaceAll(/[^a-z0-9]/gi, "") + random;
		inputNomeUsuario.placeholder = name.toLowerCase().replaceAll(/[^a-z0-9]/gi, "") + random;
	}
</script>