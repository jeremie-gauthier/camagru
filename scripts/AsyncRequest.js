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

	static #XHROnLoad = (xhr, resolve, reject) => {
		try {
			if (xhr.status >= 400) {
				resolve(xhr.statusText);
			} else {
				try {
					resolve(JSON.parse(xhr.responseText));
				} catch {
					resolve(xhr.responseText);
				}
			}
		} catch (err) {
			reject(err);
		}
	};

	static get(url) {
		return new Promise((resolve, reject) => {
			const xhr = AsyncRequest.#XHRInstance();
			xhr.open("GET", url, true);

			xhr.onload = () => AsyncRequest.#XHROnLoad(xhr, resolve, reject);

			xhr.send(null);
		});
	}

	static post(url, data) {
		return new Promise((resolve, reject) => {
			const xhr = AsyncRequest.#XHRInstance();
			xhr.open("POST", url, true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			xhr.onload = () => AsyncRequest.#XHROnLoad(xhr, resolve, reject);

			const json = JSON.stringify(data);
			xhr.send("data=" + json);
		});
	}

	static put(url, data) {
		return new Promise((resolve, reject) => {
			const xhr = AsyncRequest.#XHRInstance();
			xhr.open("PUT", url, true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			xhr.onload = () => AsyncRequest.#XHROnLoad(xhr, resolve, reject);

			const json = JSON.stringify(data);
			xhr.send("data=" + json);
		});
	}

	static delete(url) {
		return new Promise((resolve, reject) => {
			const xhr = AsyncRequest.#XHRInstance();
			xhr.open("DELETE", url, true);

			xhr.onload = () => AsyncRequest.#XHROnLoad(xhr, resolve, reject);

			xhr.send(null);
		});
	}
}
