<?php
if(isset($_SESSION['login'])){
?>
<script type="text/javascript">

function edit_userset() {
    var id = "<?php echo $_SESSION['uid'];?>";
    var role = "<?php echo $_SESSION['Role'];?>";


    $('#SettingsForm')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    if (role === 'Admin' || role === 'Moderator')
    {
        console.log("Open modal | admin");
        $("#token").show();
        $("#tokenbtn").show();
    }
    else
    {
        console.log("Open modal | user");
        $("#token").hide();
        $("#tokenbtn").hide();

    }
//Ajax Load data from ajax
    $.ajax({
        url: "<?php echo site_url('admintab/user_settings')?>/" + id + "/",
        type: "GET",
        dataType: "JSON",
        success: function (data)
        {
            $('[name="reputation"]').val(data.Reputation);
            $('[name="email"]').val(data.Email);
            $('[name="token"]').val(data.Token);
            $('#Settings').modal('show'); // show bootstrap modal when complete loaded
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function save_nav(weiter)
{

    var url;

    if(weiter == 1)
    {
        console.log("Save Rep");
        url = "<?php echo site_url('user/ajax_updaterep/')?>";

    }
    if(weiter == 2)
    {
        console.log("Save Mail");
        url = "<?php echo site_url('user/ajax_updatemail/')?>";

    }
    if(weiter == 3)
    {
        console.log("Save PW");
        url = "<?php echo site_url('user/ajax_updatepw/')?>";

    }
    if(weiter == 4)
    {
        console.log("Save Token");
        url = "<?php echo site_url('user/generate_token/')?>";

    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#SettingsForm').serialize(),

        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {

                    $('#Settings').modal('hide');
                    $('#myTable').DataTable().ajax.reload();
                $('#successmsg').parent().addClass('text-success');
                $('#successmsg').text('Daten erfolgreich gespeichert!');



            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }



        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            //alert('Error adding / update data');
            alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

            $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
            console.log('jqXHR:');
            console.log(jqXHR);
            console.log('textStatus:');
            console.log(textStatus);
            console.log('errorThrown:');
            console.log(errorThrown);
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable

        }
    });
}


</script>      
<?php
}

if(isset($_SESSION['login']) && !$_SESSION['login'] == '')
{
    $userid = TRUE;
}
else
{
    $userid = FALSE;
}
if($userid)
{
    $pfad = base_url('index.php/login/logout');
    $link = "Logout";
}
else
{
    $pfad = base_url('index.php/login/');
    $link = "Login";
}
?>

<nav class="navbar navbar-default navbar-static-top navbar-inverse">
<div class="container">
<!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
   <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="<?php echo base_url('index.php') ?>" id="navbarBrandText"></a>
  <script>

  if ($(window).width() < 1200) {
      try {

            document.getElementById("navbarBrandText").innerHTML = '<img src="<?php echo base_url('assets/images/icon.svg') ?>"  width="30" height="30" style="margin-right: 10px; display: inline-block!important;" />GHC';
   } catch (e) {
       console.log("Nicht wichtiger Fehler!: " + e);
   }
  } else {
   try {

       document.getElementById("navbarBrandText").innerHTML = '<img src="<?php echo base_url('assets/images/icon.svg') ?>" width="30" height="30" style="margin-right: 10px; display: inline-block!important;" />German Hackerz Community';
   } catch (e) {
       console.log("Nicht wichtiger Fehler!: " + e);
   }
 }
  </script>
</div>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="navbar-collapse collapse">
  <ul class="nav navbar-nav">
    <!--<li><a href="index.php">Home</a></li>-->
   
    
    <li id='navHOInfo' class='navElement'><a href="<?php echo base_url('index.php/home/hotut/'); ?>"><i class='fa fa-book fa-fw' aria-hidden='true'></i>&nbsp; Hackers Online Tuts</a></li>
      <!--<li id='HOInfo' class='navElement'><a href="<?php echo base_url('index.php/home/hostats/'); ?>"><i class='fa fa-bar-chart fa-fw' aria-hidden='true'></i>&nbsp; Hackers Online Stats</a></li>-->
    <?php
    if($userid)
    {
    ?>
        
    <li id='navIPs' class='navElement'><a href="<?php echo base_url('index.php/table/iptable/'); ?>"><i class='fa fa-laptop fa-lg' aria-hidden='true'></i>&nbsp; IPs</a></li>
    <li id='navFavoriten' class='navElement'><a href="<?php echo base_url('index.php/table/favtable/'); ?>"><i class='fa fa-star fa-lg' aria-hidden='true'></i>&nbsp; Favoriten</a></li>
    
  </ul>
  <ul class="nav navbar-nav navbar-right">
    
    
      
      <li class='dropdown' id="userDropdown">
      <a href='#' class='dropdown-toggle navUser' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><i class='fa fa-user-circle-o fa-lg' aria-hidden='true'></i>&nbsp;<?php  echo $this->session->userdata('uname'); ?>&nbsp;<span class='caret'></span></a>
      <ul class='dropdown-menu' role='menu'>
          <!--<li><a href='usersettings.php'><i class='fa fa-bar-chart fa-fw' aria-hidden='true'></i>&nbsp; Stats</a></li>
            <li><a href='usersettings.php'><i class='fa fa-bar-chart fa-fw' aria-hidden='true'></i>&nbsp; Game Account wechseln</a></li>-->
        <li><a  class="MainNavText liNavElement" id="navSettings" onclick="edit_userset()"><i class='fa fa-wrench fa-fw' aria-hidden='true'></i>&nbsp; Settings</a></li>
        <?php
        if($this->session->userdata('Role') == "Admin" OR $this->session->userdata('Role') == "Moderator")
       {
        ?>
       
        <li id='navReportedIPs' class='liNavElement'><a href='<?php echo base_url('index.php/table/repotable/'); ?>'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true'></i>&nbsp; Gemeldete IPs</a></li>
        <?php
        }
        if($this->session->userdata('Role') == "Admin")
        {
            ?>
        
        <li id='navAdmin' class='liNavElement'><a href='<?php echo base_url('index.php/admintab/'); ?>'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true'></i>&nbsp; Admin</a></li>
            <li id='navAdmin' class='liNavElement'><a href='<?php echo base_url('index.php/admintab/loginattamepts/'); ?>'><i class='fa fa-pencil-square-o fa-lg' aria-hidden='true'></i>&nbsp; Login Attempts</a></li>
        <li id='navBotCI' class='liNavElement'><a href='<?php echo base_url('index.php/botCI/'); ?>'><i class='fa fa-commenting-o fa-lg' aria-hidden='true'></i>&nbsp; BotCI</a></li>
        <?php
         } ?>
          <li role='separator' class='divider'></li>
          <li id='navLogin' class='liNavElement'><a href="<?php echo $pfad; ?>"><i class='fa fa-sign-out fa-lg' aria-hidden='true'></i>&nbsp; <?php echo $link; ?></a></li>
         <?php
         }
         ?>

       
      </ul>
      </li>
  

   

  </ul>
  <?php if(!$userid){ ?>
    <ul class="nav navbar-nav navbar-right">
    <li id='navLogin' class='navElement'><a href="<?php echo $pfad; ?>"><i class='fa fa-sign-in fa-lg' aria-hidden='true'></i>&nbsp; <?php echo $link; ?></a></li>
    </ul>
  <?php } ?>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>




<!-- HTML Form (wrapped in a .bootstrap-iso div) -->
<div class="modal fade" id="Settings" tabindex="-1" role="dialog" aria-labelledby="SettingsUserLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="EditUserLabel">User Bearbeiten</h4>
        </div>
        <div class="modal-body">
            <form method="post" id="SettingsForm">
                <div class="form-group ">
                    <label class="control-label " for="reputation">
                        Reputation
                    </label>
                    <input class="form-control" id="reputation" name="reputation" placeholder="42" type="text"/>

                </div>
                <div class="form-group "><button type="button" onclick="save_nav(1)" class="btn btn-success" form="SettingsForm">Speichern</button></div>


                <div class="form-group ">
                    <label class="control-label " for="oldpw">
                        Altes Passwort
                    </label>
                    <input class="form-control" id="oldpw" name="oldpw" type="password"/>
                </div>
                <div class="form-group ">
                    <label class="control-label " for="newpw">
                        Neues Passwort
                    </label>
                    <input class="form-control" id="newpw" name="newpw" type="password"/>
                </div>
                <div class="form-group ">
                    <label class="control-label " for="newpwrepeat">
                        Wiederholen
                    </label>
                    <input class="form-control" id="newpwrepeat" name="newpwrepeat" type="password"/>
                </div>
                <div class="form-group "><button type="button" onclick="save_nav(3)" class="btn btn-success" form="SettingsForm">Ändern</button></div>

                <div class="form-group ">
                    <label class="control-label " for="token">
                        Token
                    </label>
                    <input class="form-control" id="token" name="token" type="text"/>
                </div>
                <div class="form-group "><button type="button" id="tokenbtn" onclick="save_nav(4)" class="btn btn-danger" form="SettingsForm">Neues Token</button></div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="TableInfo" tabindex="-1" role="dialog" aria-labelledby="SettingsUserLabel" aria-hidden="true">
<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="InfoTable">Infos zur Tabelle</h4>
        </div>
        <div class="modal-body">
            <div class="form-group ">
                <label class="control-label ">
                    Sortieren:
                </label>
                <p>Um die Tabelle nach mehreren Spalten gleichzeitig zu sortieren, halte 'Shift' und wähle die anderen Spalten aus.</p>
                <p>Du kannst eine IP kopieren, indem du auf sie klickst.</p>
            </div>
            <div class="form-group ">
                <label class="control-label ">
                    Ips kopieren:
                </label>

                <p>Du kannst eine IP kopieren, indem du auf sie klickst.</p>
            </div>
            <div class="form-group ">
                <label class="control-label ">
                    Navigation:
                </label>
                <p>Benutzt die Tabulator Taste, um durch die Seite zu navigieren, oder klickt in die Tabelle und benutzt die Pfeiltasten!</p>

            </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div>

        </div>
    </div>
</div>
</div>