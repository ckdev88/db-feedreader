function expand(id) {
	let ele = id.toString();
	let descr = document.getElementById(id);
	descr.classList.toggle("show");
	let btn = document.getElementById("button-" + id);
	this.onclick = function () {
		btn.innerHTML = btn.innerHTML == "+" ? "-" : "+";
	};
}
