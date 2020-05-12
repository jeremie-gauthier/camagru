<link rel="stylesheet" type="text/css" href="components/toast.css">

<div class="camagru-toast" id="toast" hidden>
	<div class="camagru-toast-header">
		<div class="camagru-toast-sign" id="toast-sign"></div>
		<span class="camagru-toast-title">Camagru</span>
	</div>
	<span class="camagru-toast-text" id="toast-text"></span>
</div>

<script>

const toast = document.getElementById("toast");
const toastSign = document.getElementById("toast-sign");
const toastTxt = document.getElementById("toast-text");

const hideToast = (dangerosity) => {
  toast.setAttribute("hidden", "");
  toastTxt.innerHTML = "";
  toastSign.classList.remove(`camagru-toast-${dangerosity}`)
}

const showToast = (dangerosity, text) => {
  toastSign.classList.add(`camagru-toast-${dangerosity}`)
  toastTxt.innerHTML = text;
  toast.removeAttribute("hidden");
  setTimeout(() => hideToast(dangerosity), 2000);
}

</script>
