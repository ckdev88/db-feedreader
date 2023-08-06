function expand(id) {
	var descr = document.getElementById("msg-description" + id);
	var btn = document.getElementById("msg-description-button" + id);
	descr.classList.toggle("show-description");
	descr.onclick = function () {
		this.classList.toggle("show-description");
		btn.innerHTML = btn.innerHTML == "+" ? "-" : "+";
	};
	btn.innerHTML = btn.innerHTML == "+" ? "-" : "+";
}

function changeVal() {
	var select = document.getElementById("selectTimeFrame");
	var value = select.value;
	document.getElementById("refreshTimeFrame").setAttribute("value", value);
}
