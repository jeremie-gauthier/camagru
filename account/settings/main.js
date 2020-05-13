const form = document.forms.settings;
const pseudoErr = document.getElementById("pseudo-error");
const emailErr = document.getElementById("email-error");
const confirmBtn = document.getElementById("btn-confirm");
const modifyBtn = document.getElementById("btn-modify");

// DEFINING STATES
const props = {
	origPseudo: form.pseudo.value,
	origEmail: form.email.value,
	pseudo: form.pseudo.value,
	email: form.email.value,
};

const handlers = {
	set: (obj, prop, value) => {
		obj[prop] = value;
		if (prop === "pseudo" || prop === "email") {
			if (
				state.pseudo === state.origPseudo &&
				state.email === state.origEmail
			) {
				confirmBtn.disabled = true;
			} else {
				confirmBtn.disabled = false;
			}
		}
	},
};

const state = new Proxy(props, handlers);

// SET EVENTS
form.pseudo.onkeyup = () => {
	state.pseudo = form.pseudo.value;
	checkPseudo(state.pseudo, pseudoErr);
};

form.email.onkeyup = () => {
	state.email = form.email.value;
	checkEmail(state.email, emailErr);
};

const submitForm = async () => {
	checkPseudo(state.pseudo, pseudoErr);
	checkEmail(state.email, emailErr);

	if ([pseudoErr, emailErr].every((elem) => elem.innerHTML === "")) {
		try {
			const url = "/account/settings/handler.php";
			const data = { pseudo: state.pseudo, email: state.email };
			const headers = { "Content-type": "application/x-www-form-urlencoded" };

			await AsyncRequest.put(url, data, headers);
			state.origPseudo = state.pseudo;
			state.origEmail = state.email;
			modifyBtnToggler();
			showToast("success", "Modifications enregistrées");
		} catch (err) {
			showToast("error", err.message ?? err);
		}
	}
};

const modifyBtnToggler = () => {
	if (confirmBtn.hidden === true) {
		modifyBtn.innerHTML = "Annuler";
		confirmBtn.hidden = false;
		form.pseudo.disabled = false;
		form.email.disabled = false;
	} else {
		modifyBtn.innerHTML = "Modifier mes informations";
		form.pseudo.value = state.origPseudo;
		form.email.value = state.origEmail;
		confirmBtn.hidden = true;
		form.pseudo.disabled = true;
		form.email.disabled = true;
		state.pseudo = state.origPseudo;
		state.email = state.origEmail;
	}
};

const changePassword = () => {
	try {
		const info = document.getElementById("settings-info");
		const url = `/account/settings/handler.php?email=${state.origEmail}`;

		AsyncRequest.get(url);
		info.innerHTML =
			"Un mail contenant des instructions de reinitialisation vient de vous etre envoye";
	} catch (err) {
		showToast("error", err.message);
	}
};
