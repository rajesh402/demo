$(document).ready(function() { 
    $.validator.addMethod("accept", function(value, element, param) {
        return value.match(new RegExp("^" + param + "$"));
    }, "Please enter valid value.");

    $.validator.addMethod("noSpace", function(value, element)
    {
        return value.indexOf(" ") < 0 && value != "";
    }, "Space is not allowed.");
    
    $("#UsersRegistrationForm").validate({
        rules: {
            fname: {
                required:true,
                accept: "[a-zA-Z]+",
            },
            ustate:{
                required:true,
            },
            uzip:{
                required:true,
                digits:true,
                minlength : 6
            },
            uemail:{
                required:true,
                email:true
            },
            ubirth:{
                required:true
            },
             userpass:{
                required : true, 
                minlength :6,
                noSpace : true
            },
             confpass:{
                required : true, 
                equalTo : '[name=userpass]'
            }
           
           
        },

        messages: {
            fname: {
                required: "Please enter your fname",
                accept: "Only alphabets are allowed"
            },
            ustate:{
                required:"Please Select your state"
            },
            uzip:{
                required:"Please provide your Zip",
                digits:"Only Digits required",
                minlength:"Atlease 6 characters are required"
            },
            uemail:{
                required:"Please Enter your Email",
                email:"Please Enter Valid Email"
            },
            ubirth:{
                required:"Please, Enter your Date Birth"
            },
            userpass:{
                required:"Please Enter your Password",
                minlength:"Minimum Length of Password must be of 6 characters",
                noSpace:"Spaces are not allowed"
            }
            
        },
    }); //end of #UsersRegistrationForm
    
    $( "#ubirth" ).datepicker({
            showOn: "button",
            buttonImage: "../../images/calendar.gif",            
            buttonImageOnly: false,
            dateFormat: 'yy-mm-dd'
    });
    
    $("#ubirth").attr('readonly', 'readonly');
    
});//end of main
