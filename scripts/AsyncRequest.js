class AsyncRequest {
	static #XHRInstance = () => {
		try {
			return new XMLHttpRequest();
		} catch (e) {
			try {
				return new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				return new ActiveXObject("Msxml2.XMLHTTP");
			}
		}
	};

	static get(url) {
		return new Promise((resolve, reject) => {
			const xhr = AsyncRequest.#XHRInstance();
			xhr.open("GET", url, true);

			xhr.onload = () => {
				try {
					const response = JSON.parse(xhr.responseText);
					resolve(response);
				} catch (err) {
					reject(err);
				}
			};

			xhr.send(null);
		});
	}

	static post(url, data) {
		return new Promise((resolve, reject) => {
			const xhr = AsyncRequest.#XHRInstance();
			xhr.open("POST", url, true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			xhr.onload = () => {
				try {
					const response = JSON.parse(xhr.responseText);
					resolve(response);
				} catch (err) {
					reject(err);
				}
			};

			const json = JSON.stringify(data);
			xhr.send("data=" + json);
		});
	}

	static put(url, data) {
		return new Promise((resolve, reject) => {
			const xhr = AsyncRequest.#XHRInstance();
			xhr.open("PUT", url, true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			xhr.onload = () => {
				try {
					const response = JSON.parse(xhr.responseText);
					resolve(response);
				} catch (err) {
					reject(err);
				}
			};

			const json = JSON.stringify(data);
			xhr.send("data=" + json);
		});
	}

	static delete(url) {
		return new Promise((resolve, reject) => {
			const xhr = AsyncRequest.#XHRInstance();
			xhr.open("DELETE", url, true);

			xhr.onload = () => {
				try {
					const response = JSON.parse(xhr.responseText);
					resolve(response);
				} catch (err) {
					reject(err);
				}
			};

			xhr.send(null);
		});
	}
}
