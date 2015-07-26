/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('#submit').on('click',function(){
        
        $("#signin").validate({
            rules: {
                vUsername: "required",
                vPassword: {
                  required: true
                }
            },
            messages: {
                    vUsername: {
                            required: "Please enter your username"
                    },
                    vPassword: {
                            required: "Please provide your password"
                    }
            }
        });
        
        if($("#signin").valid()){
            $.ajax({
                url: 'signin_act.php',
                type: 'POST',
                data: {
                    'vUsername' : $('#vUsername').val(),
                    'vPassword' : $('#vPassword').val()
                },
                success: function(data) {
                        if(data == 'success'){
                            window.location = "dashboard.php";
                        } else {
                            alert('Please enter valid credentials')
                            window.location = "signin.php";
                        }
                },
                error: function(e) {
                        console.log(e.message);
                }
            });
            
        }
    });
    
    
});
