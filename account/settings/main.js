const form = document.forms.settings;
const pseudoErr = document.getElementById("pseudo-error");
const emailErr = document.getElementById("email-error");
const confirmBtn = document.getElementById("btn-confirm");
const modifyBtn = document.getElementById("btn-modify");

window.onload = () => {
	form.pseudo.addEventListener("blur", () =>
		checkPseudo(form.pseudo.value, pseudoErr)
	);
	form.email.addEventListener("blur", () =>
		checkEmail(form.email.value, emailErr)
	);
};

const submitForm = () => {
	checkPseudo(form.pseudo.value, pseudoErr);
	checkEmail(form.email.value, emailErr);
	return [pseudoErr, emailErr].every((elem) => elem.innerHTML === "");
};

const modifyBtnToggler = () => {
	if (confirmBtn.hidden === true) {
		modifyBtn.innerHTML = "Annuler";
		confirmBtn.hidden = false;
		form.pseudo.disabled = false;
		form.email.disabled = false;
	} else {
		modifyBtn.innerHTML = "Modifier mes informations";
		confirmBtn.hidden = true;
		form.pseudo.disabled = true;
		form.email.disabled = true;
	}
};
