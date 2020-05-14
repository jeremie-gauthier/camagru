const overlay = document.getElementById("overlay-container");

overlay.onclick = (e) => {
	if (e.target.id === overlay.id) {
		overlay.hidden = true;
	}
};

overlay.onkeyup = (e) => {
	if (e.key === "Escape") {
		overlay.hidden = true;
	}
};

const forgottenPassword = () => {
	const feedback = document.getElementById("overlay-feedback");

	feedback.innerHTML = "";
	overlay.hidden = false;
	document.getElementById("overlay-input").focus();
};

const resetPwd = async () => {
	const forgotBtn = document.getElementById("overlay-btn");
	const feedback = document.getElementById("overlay-feedback");
	const spinner = document.getElementById("load-indicator");

	try {
		const email = document.getElementById("overlay-input").value;
		const url = `/auth/login/handler.php?email=${email}`;

		feedback.innerHTML = "";
		forgotBtn.disabled = true;
		spinner.hidden = false;

		const res = await AsyncRequest.get(url);
		document.getElementById("info-text").innerHTML = res;
		document.getElementById("error-text").innerHTML = "";
		overlay.hidden = true;
	} catch (err) {
		feedback.innerHTML = err;
	} finally {
		spinner.hidden = true;
		forgotBtn.disabled = false;
	}
};
