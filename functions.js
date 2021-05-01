function setFields()
{
	var el = document.getElementById("radmap-input");

	if(document.getElementById("mode1").checked)
		el.style.display = "block";
	else
	{
		el.style.display = "none";
		document.getElementById("rd").value = null; // clears the radiomap upload field when unchecking the option.
	}
}