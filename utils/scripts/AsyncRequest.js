/**
 * A class to make RESTful Promise-based AJAX requests.
 * No need to instantiate this class with the `new` keyword
 * as it contains only static methods.
 */
class AsyncRequest {
	static _XHRInstance = () => {
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

	static _XHRSetHeaders = (xhr, headers) => {
		const headers_array = Object.entries(headers);
		headers_array.forEach(([header, value]) =>
			xhr.setRequestHeader(header, value)
		);
	};

	static _XHROnLoad = (xhr, resolve, reject) => {
		try {
			if (xhr.status >= 400) {
				if (xhr.responseText && xhr.responseText != "") {
					reject(xhr.responseText);
				} else {
					reject(new Error(xhr.statusText));
				}
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

	/**
	 * @type {string} url
	 * @type {object|undefined} headers
	 */
	static get(url, headers = null) {
		return new Promise((resolve, reject) => {
			const xhr = AsyncRequest._XHRInstance();

			xhr.open("GET", url, true);
			if (headers) {
				AsyncRequest._XHRSetHeaders(xhr, headers);
			}

			xhr.onload = () => AsyncRequest._XHROnLoad(xhr, resolve, reject);

			xhr.send(null);
		});
	}

	/**
	 * @type {string} url
	 * @type {object} data
	 * @type {object|undefined} headers
	 */
	static post(url, data, headers = null) {
		return new Promise((resolve, reject) => {
			const xhr = AsyncRequest._XHRInstance();

			xhr.open("POST", url, true);
			if (headers) {
				AsyncRequest._XHRSetHeaders(xhr, headers);
			}

			xhr.onload = () => AsyncRequest._XHROnLoad(xhr, resolve, reject);

			const json = JSON.stringify(data);
			xhr.send("data=" + json);
		});
	}

	/**
	 * @type {string} url
	 * @type {object} data
	 * @type {object|undefined} headers
	 */
	static put(url, data, headers = null) {
		return new Promise((resolve, reject) => {
			const xhr = AsyncRequest._XHRInstance();

			xhr.open("PUT", url, true);
			if (headers) {
				AsyncRequest._XHRSetHeaders(xhr, headers);
			}

			xhr.onload = () => AsyncRequest._XHROnLoad(xhr, resolve, reject);

			const json = JSON.stringify(data);
			xhr.send("data=" + json);
		});
	}

	/**
	 * @type {string} url
	 * @type {object|undefined} headers
	 */
	static delete(url, headers = null) {
		return new Promise((resolve, reject) => {
			const xhr = AsyncRequest._XHRInstance();

			xhr.open("DELETE", url, true);
			if (headers) {
				AsyncRequest._XHRSetHeaders(xhr, headers);
			}

			xhr.onload = () => AsyncRequest._XHROnLoad(xhr, resolve, reject);

			xhr.send(null);
		});
	}
}
