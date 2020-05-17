const listComs = document.getElementById("list-comments");
const cache = [];

const toggleComments = async (commentsContainer, arrowIcon, pictureId) => {
	if (arrowIcon.classList.contains("arrow-up")) {
		arrowIcon.classList.remove("arrow-up");
		arrowIcon.classList.add("arrow-down");
		commentsContainer.hidden = false;
		if (!cache.includes(pictureId)) {
			const comments = await fetchComments(pictureId);
			commentsToDOM(commentsContainer, pictureId, comments);
		}
	} else if (arrowIcon.classList.contains("arrow-down")) {
		arrowIcon.classList.remove("arrow-down");
		arrowIcon.classList.add("arrow-up");
		commentsContainer.hidden = true;
	}
};

const fetchComments = async (pictureId) => {
	try {
		const url = `/gallery/src/comments.php?pictureId=${pictureId}`;

		const comments = await AsyncRequest.get(url);
		cache.push(pictureId);
		return comments;
	} catch (err) {
		showToast("error", err.message ?? err);
	}
};

const commentsToDOM = (commentsContainer, pictureId, comments) => {
	comments.forEach((comment) => {
		const comDiv = createElement(commentsContainer, "div", {
			class: "comment-block",
		});
		const headerDiv = createElement(comDiv, "div", {
			class: "comment-header inline",
		});
		createElement(
			headerDiv,
			"strong",
			{ class: "comment-author" },
			comment.author
		);
		if (currentUser !== null && comment.author === currentUser) {
			const delIcon = createElement(
				headerDiv,
				"i",
				{ class: "material-icons comment-delIcon" },
				"clear"
			);
			delIcon.onclick = () =>
				delComment(pictureId, comDiv, comment.idComments, currentUser);
		}
		createElement(comDiv, "p", { class: "comment-txt" }, comment.comment);
		createElement(comDiv, "span", { class: "comment-date" }, comment.regDate);
	});
};

const openComment = (pictureId) => {
	try {
		current = pictureId;
		overlayCom.hidden = false;
		overlayTextCom.focus();
	} catch (err) {
		showToast("error", err.message ?? err);
	}
};

const addComment = async () => {
	const counter = document.getElementById(`sum-comments-card${current}`);

	try {
		const url = "/gallery/src/comments.php";
		const data = { pictureId: current, comment: overlayTextCom.value };
		const headers = { "Content-type": "application/x-www-form-urlencoded" };

		overlayCom.hidden = true;
		overlayTextCom.value = "";
		current = null;
		counter.innerHTML = parseInt(counter.innerHTML) + 1;
		await AsyncRequest.post(url, data, headers);
	} catch (err) {
		showToast("error", err.message ?? err);
		counter.innerHTML = parseInt(counter.innerHTML) - 1;
	}
};

const delComment = async (pictureId, comDiv, commentId, userId) => {
	if (userId === null) {
		window.location.href = "http://127.0.0.1:8888/auth/login";
	}
	const counter = document.getElementById(`sum-comments-card${pictureId}`);

	try {
		const url = `/gallery/src/comments.php?commentId=${commentId}&currentUser=${userId}`;

		comDiv.hidden = true;
		counter.innerHTML = parseInt(counter.innerHTML) - 1;
		await AsyncRequest.delete(url);
	} catch (err) {
		showToast("error", err.message ?? err);
		comDiv.hidden = false;
		counter.innerHTML = parseInt(counter.innerHTML) + 1;
	}
};
