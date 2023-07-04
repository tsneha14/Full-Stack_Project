let flag = true

$(document).ready(function() {
    $("#myform").submit(e => {
        e.preventDefault();
        flag = true
        console.log("sss",flag);
       
        let firstNameRegex = /^[a-zA-Z'\s]{3,8}$/
        let stateList = ['AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY' ];
        let emailRegex = /^[a-zA-Z][a-zA-Z0-9_.'\-]*@[a-zA-Z]+(.[a-zA-Z]+){1,2}$/
        let passwordRegex = /^[a-zA-Z][a-zA-Z0-9]{5,}$/
        let mobileRegex = /^\d{3}-\d{3}-\d{4}$/
        
        let firstName = $("#firstName").val();
        let lastName = $("#lastName").val();
        let email = $("#email").val();
        let mobile = $("#mobile").val();
        let state = $("#state").val();
        let city = $("#city").val();

        // Validating firstname,lastname,mobile fields
        validateRegex("firstName","fnameErr",firstNameRegex,"firstname")
        validateRegex("lastName","lnameErr",firstNameRegex,"lastname")
        validateRegex("email","emailErr",emailRegex,"email")
        validateRegex("mobile","mobileErr",mobileRegex,"mobile number in the format xxx-xxx-xxxx")

        // Validating state field
        if(!stateList.includes(state)) {
            flag = false
            $(".stateErr").removeClass("hidden text-success")
                .addClass("text-danger")
                .html("Please enter valid postal state abbreviation")
                .show();
        } else  {
            $(".stateErr").removeClass("hidden text-danger")
                .addClass("text-success")
                .html("Success")
                .show();
        }
       
        //validate password
        validateRegex("password","passErr",passwordRegex,"password")

        //validate confirm password
        let password = $("#password").val();
        let confirmPassword = $("#confirmPassword").val();

        if(password && confirmPassword && password != confirmPassword) {
            flag = false
            $(".confirmPassErr").removeClass("hidden text-success")
                .addClass("text-danger")
                .html("Password do not match with the above")
                .show();
        } else if(password && confirmPassword) {
            $(".confirmPassErr").removeClass("hidden text-danger")
                .addClass("text-success")
                .html("Success")
                .show();
        }
        if(flag) {
            console.log("hhh")
            $.ajax({
                type: "POST",
                url: "http://localhost/project/form.php",
                data: "firstName="+firstName+
                      "&lastName="+lastName+
                      "&mobile="+mobile+
                      "&email="+email+
                      "&city="+city+
                      "&state="+state+
                      "&password="+password,
                success: function(response) {
                    if (response === 'success') {
                      alert("Form Submitted successfully")
                    } else {
                      alert(response)
                    }
                  },
                error: function(xhr, status, error) {
                    alert('There was an error processing your request.');
                }
              })
        }
        
    });
});

const validateRegex = (id,errId,regex,text) => {
    if(!$("#"+id).val().match(regex)) {
        flag = false
        $("."+errId).removeClass("hidden text-success")
            .addClass("text-danger")
            .html("Please enter valid " +text)
            .show();
    } else {
        $("."+errId).removeClass("hidden text-danger")
            .addClass("text-success")
            .html("Success")
            .show();
    }
}