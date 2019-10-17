
//function to remove email tags on clicking x button.
$('#tags').on('click', 'span', function () {
    $(this).remove();
});

var backKeyPressed = 0;

//function to remove added email address on pressing back key.
$(".emailtag").on({
    keyup: function (ev) {
        if (/(8)/.test(ev.which)) {
            if ($('#tags span').last().hasClass("focusTag")) {
                backKeyPressed++;
                if (backKeyPressed % 2 === 0) {
                    $('#tags span').last().remove();
                    $('#tags span').last().addClass("focusTag");
                    backKeyPressed = 1;
                }
            }
        }
    }
})


//function to validate entered strings.
$("#tags input").on({
    keyup: function (ev) {
        if (/(13|32)/.test(ev.which) && this.value) {
            validateEmail(this.value, this);
        }
        if (/(8)/.test(ev.which)) {
            if (!this.value) {
                if ($('#tags span').last().hasClass("focusTag")) {
                }
                else {
                    $('#tags span').last().addClass("focusTag");
                }
            }
        }
    }
})

//validate email address
function validateEmail(inputValue, that) {
    var emailAddresses = inputValue.replace(/\s+$/, '').split(",");
    var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    emailAddresses.forEach(function (emailAddress) {
        if (regex.test(emailAddress)) {
            $("<span/>", { text: emailAddress.toLowerCase(), insertBefore: that, class: 'emailAdd', tabindex: '1' });
        }
        else {
            alert("invalid");
        }
    });
    that.value = "";
}
