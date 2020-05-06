<link rel="stylesheet" type="text/css" href="components/toast.css">

<div class="camagru-toast" id="toast" hidden>
	<div class="camagru-toast-header">
		<div class="camagru-toast-sign camagru-toast-error"></div>
		<span class="camagru-toast-title">Camagru</span>
	</div>
	<span class="camagru-toast-text" id="toast-text"></span>
</div>

<script>

const toast = document.getElementById("toast");
const toastTxt = document.getElementById("toast-text");

const hideToast = () => {
  toastTxt.innerHTML = "";
  toast.setAttribute("hidden", "");
}

const showToast = (text) => {
  toastTxt.innerHTML = text;
  toast.removeAttribute("hidden");
  setTimeout(() => hideToast(), 2000);
}

</script>
