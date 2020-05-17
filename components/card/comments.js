const comToggler = document.getElementById("comments-toggler");
const listComs = document.getElementById("list-comments");
const cache = [];

const toggleComments = async (pictureId) => {
	const arrow = comToggler.children[1];

	if (arrow.classList.contains("arrow-up")) {
		arrow.classList.remove("arrow-up");
		arrow.classList.add("arrow-down");
		listComs.hidden = false;
		if (!cache.includes(pictureId)) {
			const comments = await fetchComments(pictureId);
			commentsToDOM(pictureId, comments);
		}
	} else if (arrow.classList.contains("arrow-down")) {
		arrow.classList.remove("arrow-down");
		arrow.classList.add("arrow-up");
		listComs.hidden = true;
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

const commentsToDOM = (pictureId, comments) => {
	const formatDate = (date) => {
		const d = new Date(date);
		return d.toDateString();
	};

	comments.forEach((comment) => {
		const comDiv = createElement(listComs, "div", { class: "comment-block" });
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
