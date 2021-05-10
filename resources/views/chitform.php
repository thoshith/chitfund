<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
    body{
        background-color: #FFFAFA;

        /*background-image: url("http://localhost/laravel/images/money.jpg"); */
    }
    li{
        padding: 4px;
    }
    a{
        color: white;
    }
    
     #chitform{
        padding-top: 100px;
        width: 75%;
        margin-left: 200px;
     }

     #amount{
        width: 30%;
     }
     #chitname{
        width: 30%;
     }
     #paid_date , #due_date{
    width: 40%;
     }
     #image{
        border-style: dotted;
        background-color: #B0E0E6;
        width:50%; 
        border-radius: 3px;
        box-shadow:  5px 5px #adb5bd;
     }

</style>
<script>
    var monthly_data={};
    var chit_id;
    var member_id;
    var chit_name;
    var amount;
    var paid_date;
    var due_date;

    $( document ).ready(function() {
     
        display_chitsnames();//load to dropdown chit names
        display_members();//load to dropdown member names

        // get the chitname from dropdown
        $('#chitnames').on('change',function() {
            chit_name=$(this).val();
            console.log("chit_name"+chit_name);
        });


        // get the member name from dropdown
        $('#memberName').on('change',function() {
            member_id=$(this).val();
            console.log("member_id"+member_id);
        });

        // sending data to db 
        $('#post_data').on('click',function() {
            submit_data();
        });
   
  });
       
   // Load dropdown with member names
   function display_members(){
        $("#tab").empty();
        var table_content='';
        $.ajax({
            url:'/api/members/',
            type: 'GET',
            success: function (response) {
            option_content="";
            for( i=0;i<response.data.length;i++) {
                option_content+='<option value='+response.data[i].member_id+'>'+response.data[i].member_name+'</option>';
            } 
            $("#memberName").append( option_content);
         }

     });
    }

     // Load dropdown with chit names
    function display_chitsnames(){
        $("#tab").empty();
        var table_content='';
        $.ajax({
            url:'/api/chits/',
            type: 'GET',
            success: function (response) {
          
            option_content="";
            for( i=0;i<response.data.length;i++) {
                option_content+='<option value='+response.data[i].chit_name+'>'+response.data[i].chit_name+'</option>';
            }
                $("#chitNames").append(option_content);
        }
    });
          
         
}


  // post data to table(lucky_lakshmi_details)
    function submit_data(){

        amount=$('#amount').val();
        paid_date=$('#paid_date').val();
        due_date=$('#due_date').val();


        monthly_data.chit_name=chit_name;
        monthly_data.chit_number=1;
        monthly_data.member_id=member_id;
        monthly_data.amount_paid=amount;
        monthly_data.paid_date=paid_date;
        monthly_data.due_date=due_date;
        console.log(monthly_data);

                    $.ajax({
                        url:'/api/monthly_chitamount',
                        type: 'POST',
                        data: monthly_data,
                        success: function (response, textStatus, xhr) {
                            console.log(response);
                           if(response.data.length ===1 ) {
                                alert("submitted successfull :" );
                                //document.location.href="";
                            } else {
                                alert("plz fill form again... something is wrong");
                            }
                        },
                        error: function (response, textStatus, errorThrown) {
                            if (response && response.responseJSON && response.responseJSON.message) {
                                alert(response.responseJSON.message);
                            } else {
                                alert("something wrong happened");
                            }
                        }
                   });

}
    


</script>
</head>
<body>

    <div class="container">
        <div id="first_div">
            <h1>Chit Funds </h1>

        </div>
        <div>
            <nav class="navbar navbar-expand-sm bg-primary">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="http://127.0.0.1:8000/adminviewdetails">Back</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://127.0.0.1:8000/index">Logout</a>
                    </li>
                    
                </div>
            </li>

        </ul>
    </nav>

</div>

<div id="chitform">
    <form>
        <div class="row">
  <div class="col-6 col-md-6">

<div class="form-group">
    <label for="chitname">Chit Names</label><br>
        <select  id="chitNames" name="chitname" >
        <option value="">Select the Chit Name</option>
        </select>
    </div>
  
  <div class="form-group">
    <label for="memberName">Member Names</label><br>
        <select  id="memberName" name="chitname" >
        <option value="">Select the Member Name</option>
        </select>
    </div>
      <div class="form-group">
    <label for="amount">Amount</label>
    <input type="text" class="form-control" id="amount" >
  </div>
    <div class="form-group">
      <label for="paid_date" >Paid Date</label>
      <input type="date" class="form-control" id="paid_date">
    </div>

    <div class="form-group">
      <label for="due_date" >Due Date</label>
      <input type="date" class="form-control" id="due_date">
    </div>
 
    <button type="submit" class="btn btn-primary" id="post_data" >Submit</button>
 
 </div>
  <div class="col-6 col-md-6" id="image">

  </div>
</div>
        
     
</form>
</div>



</div>


</body>
</html>
