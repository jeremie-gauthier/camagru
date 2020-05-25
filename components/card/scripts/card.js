const template = document.getElementById("template-card");
let currentOffset = 0;

const fetchCards = async (element, user = null, self = false) => {
	try {
		const url = `/components/card/request.php?offset=${currentOffset}&limit=5&user=${user}&self=${self}`;
		currentOffset += 5;
		const pictures = await AsyncRequest.get(url);
		addPicturesToDOM(element, pictures);
		return pictures.length === 5;
	} catch (err) {
		currentOffset -= 5;
		throw err;
	}
};

const addPicturesToDOM = (element, pictures) => {
	pictures.forEach((picture) => {
		const clone = document.importNode(template.content, true);
		const {
			alreadyLiked,
			author,
			comments,
			diUsers,
			idPictures,
			legend,
			likes,
			regDate,
		} = picture;

		clone.getElementById("card-img").src = `/assets/users/${idPictures}.png`;

		clone.getElementById("card-title").innerHTML = author;

		const likeCounter = clone.getElementById("sum-likes-card");
		likeCounter.innerHTML = likes;

		const like = clone.getElementById("like-card");
		if (alreadyLiked === "0") like.innerHTML = "favorite_border";
		else if (alreadyLiked === "1") like.innerHTML = "favorite";
		like.onclick = () =>
			isUserLogged(likePicture)(like, likeCounter, idPictures);

		const commentCounter = clone.getElementById("sum-comments-card");
		commentCounter.id += idPictures;
		commentCounter.innerHTML = comments;

		const comment = clone.getElementById("comment-card");
		comment.onclick = () => isUserLogged(openComment)(idPictures);

		const cardLegend = clone.getElementById("legend-card");
		cardLegend.id += idPictures;
		cardLegend.innerHTML = legend;

		const btnComments = clone.getElementById("comments-toggler");
		const commentsContainer = clone.getElementById("list-comments");
		commentsContainer.id += idPictures;
		btnComments.onclick = () =>
			toggleComments(commentsContainer, btnComments.children[1], idPictures);

		if (currentUser !== null && currentUser.id === diUsers) {
			const cardActions = clone.getElementById("card-owner-actions");
			const [updateBtn, delBtn] = cardActions.children;
			const card = clone.getElementById("card");

			updateBtn.onclick = () => openLegend(cardLegend, idPictures);
			delBtn.onclick = () => delPicture(card, idPictures);
			updateBtn.hidden = false;
			delBtn.hidden = false;
		}

		clone.getElementById("card-img-date").innerHTML = regDate;

		element.appendChild(clone);
	});
};

/*
 ** CARD ACTIONS
 */

const openLegend = (legend, pictureId) => {
	try {
		overlay.hidden = false;
		overlayText.focus();
		overlayText.value = legend.innerHTML;
		overlayText.selectionStart = overlayText.textLength;
		counter.innerHTML = overlayText.textLength + "/255";
		current = pictureId;
	} catch (err) {
		showToast("error", err.message ?? err);
	}
};

const putLegend = async () => {
	const pictureLegend = document.getElementById(`legend-card${current}`);
	const tmp = pictureLegend.innerHTML;

	try {
		const url = "/gallery/src/handler.php";
		const data = { pictureId: current, legend: overlayText.value };
		const headers = { "Content-type": "application/x-www-form-urlencoded" };

		pictureLegend.innerHTML = overlayText.value;
		overlay.hidden = true;
		current = null;
		await AsyncRequest.put(url, data, headers);
	} catch (err) {
		showToast("error", err.message ?? err);
		pictureLegend.innerHTML = tmp;
	}
};

const delPicture = async (element, pictureId) => {
	try {
		const url = `picture/src/handler.php?id=${pictureId}`;

		element.hidden = true;
		nbPictures--;
		if (nbPictures === 0) {
			noPicInfo.hidden = false;
		}
		await AsyncRequest.delete(url);
		showToast("success", "Image supprim&eacute;e");
	} catch (err) {
		showToast("error", err.message ?? err);
		element.hidden = false;
		nbPictures++;
		noPicInfo.hidden = true;
	}
};
