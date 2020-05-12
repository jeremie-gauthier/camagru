const checkPseudo = (pseudo, err) => {
	const pattern = /[^a-zA-Z\d\-]/;

	if (pseudo === "") {
		err.innerHTML = "Champ requis";
	} else if (pseudo.length < 3) {
		err.innerHTML = "Votre pseudo doit etre compose de 3 caracteres minimum";
	} else if (pseudo.length > 16) {
		err.innerHTML = "Votre pseudo doit etre compose de 16 caracteres maximum";
	} else if (pseudo.match(pattern)) {
		err.innerHTML =
			"Votre pseudo ne doit contenir que des lettres, des chiffres ou un trait d'union";
	} else {
		err.innerHTML = "";
	}
};

const checkEmail = (email, err) => {
	const pattern = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;

	if (email === "") {
		err.innerHTML = "Champ requis";
	} else if (!email.match(pattern)) {
		err.innerHTML = "Adresse mail non valide";
	} else {
		err.innerHTML = "";
	}
};

const checkPwd = (pwd, confirmPwd, err) => {
	const isUpper = () => pwd.match(/[A-Z]/);
	const isLower = () => pwd.match(/[a-z]/);
	const isDigit = () => pwd.match(/\d/);
	const isSpecial = () =>
		pwd.match(/[ !\"#\$%&'\(\)\*\+,-\.\/\\:;<=>\?@\[\]\^_`{\|}~]/);
	const checkChar = () => isUpper() && isLower() && isDigit() && isSpecial();

	if (pwd === "") {
		err.innerHTML = "Champ requis";
	} else if (pwd.length < 8) {
		err.innerHTML = "Votre mot de passe doit contenir au moins 8 caracteres";
	} else if (!checkChar()) {
		err.innerHTML =
			"Votre mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caractere special";
	} else if (pwd !== confirmPwd) {
		err.innerHTML = "Les mots de passe ne sont pas identiques";
	} else {
		err.innerHTML = "";
	}
};
