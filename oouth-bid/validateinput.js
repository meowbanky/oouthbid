< script >

    function checkForm(form) {
        ...
        if(!form.terms.checked) {
            alert("Please select a checkbox");
            form.terms.focus();
            return false;
        }
        return true;
    }

<
/script>

<
form...onsubmit = "return checkForm(this);" >
    ... <
    p > < input type = "checkbox"
name = "yes" > YES < /p> <
p > < input type = "checkbox"
name = "yes" > NO < /p> <
p > < input type = "submit" > < /p>  < /
    form >