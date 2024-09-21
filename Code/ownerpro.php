<?php
    include "base.php";
    session_start();
    $id=$_SESSION['id'];
    $query="select *  from `user` where `userid`='$id'";
    $run=mysqli_query($con, $query);
    $val=mysqli_fetch_assoc($run);
    $user=$val['user'];
    $email=$val['email'];
    $ph=$val['ph'];
    $gen=$val['gender'];
    $add=$val['address'];
    $sql_acc="select * from `account` where `userid`='$id'";
    $val_acc=mysqli_fetch_assoc(mysqli_query($con, $sql_acc));
    $acc=$val_acc['acc'];
    $bnk=$val_acc['bank'];
    $br=$val_acc['brunch'];
    $ifsc=$val_acc['ifsc'];
    if(isset($_POST['usave'])){
        $user=$_POST['user'];
        $query="update `user` set `user`='$user' where `userid`='$id'";
        $run1=mysqli_query($con,$query);
    }
    if(isset($_POST['esave'])){
        $email=$_POST['email'];
        $query="update `user` set `email`='$email' where `userid`='$id'";
        $run1=mysqli_query($con,$query);
    }
    if(isset($_POST['psave'])){
        $ph=$_POST['ph'];
        $query="update `user` set `ph`='$ph' where `userid`='$id'";
        $run1=mysqli_query($con,$query);
    }
    if(isset($_POST['gsave'])){
        $gen=$_POST['gen'];
        $query="update `user` set `gender`='$gen' where `userid`='$id'";
        $run1=mysqli_query($con,$query);
    }
    if(isset($_POST['asave'])){
        $add=$_POST['add'];
        $query="update `user` set `address`='$add' where `userid`='$id'";
        $run1=mysqli_query($con,$query);
    }
    if(isset($_POST['accsave'])){
        $acc=$_POST['acc'];
        $query="update `account` set `acc`='$acc' where `userid`='$id'";
        $run1=mysqli_query($con,$query);
    }
    if(isset($_POST['bnksave'])){
        $br=$_POST['br'];
        $query="update `account` set `brunch`='$br' where `userid`='$id'";
        $run1=mysqli_query($con,$query);
    }
    if(isset($_POST['isave'])){
        $ifsc=$_POST['ifsc'];
        $query="update `account` set `ifdc`='$ifsc' where `userid`='$id'";
        $run1=mysqli_query($con,$query);
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">  
    <link rel="stylesheet" href="css/back.css?v=<?php echo time() ?>">  
    <link rel="stylesheet" href="css/navbar.css?v=<?php echo time() ?>">
    <link rel="stylesheet" href="css/ownerpro.css?v=<?php echo time() ?>">
    <title>Profile</title>
</head>
<body>
    <div class="main">
        <?php
            include "navbar.php";
        ?>
        <div class="box">
            <h1>Account Details</h1>
            <div class="inputfield">
                <div class="user">
                    <form action="" method="post" >
                        <label for="user">Username</label>
                        
                        <br>
                        <input type="text" id="user" name="user" value="<?php echo $user; ?>" disabled >
                        <span onclick="uch()" id="uedit" >Edit</span>
                        <br>
                        <div class="btn" id="ubtn" >
                            <button id="usave" name="usave" >Save</button>
                            <button id="ucan" onclick="ucancel()" >Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="email">
                    <form action="" method="post" >
                        <label for="email"  >Email</label>
                        
                        <br>
                        <input type="email" id="email" name="email" value="<?php echo $email; ?>" disabled >
                        <span onclick="ech()" id="eedit" >Edit</span>
                        <br>
                        <div class="btn" id="ebtn" >
                            <button id="esave" name="esave" >Save</button>
                            <button id="ecan" onclick="ecancel()" >Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="ph">
                    <form action="" method="post" >
                        <label for="ph">Ph No.</label>
                        
                        <br>
                        <input type="text" id="ph" name="ph" value="<?php echo $ph; ?>" disabled >
                        <span onclick="pch()" id="pedit" >Edit</span>
                        <br>
                        <div class="btn" id="pbtn" >
                            <button id="psave" name="psave" >Save</button>
                            <button id="pcan" onclick="pcancel()" >Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="gen">
                    <form action="" method="post" >
                        <label for="gen">Gender</label>
                        
                        <br>
                        <input type="text" id="gen" name="gen" value="<?php echo $gen; ?>" disabled >
                        <span onclick="gch()" id="gedit" >Edit</span>
                        <br>
                        <div class="btn" id="gbtn" >
                            <button id="gsave" name="gsave" >Save</button>
                            <button id="gcan" onclick="gcancel()" >Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="add">
                    <form action="" method="post" >
                        <label for="add">Address</label>
                        
                        <br>
                        <input type="text" id="add" name="add" value="<?php echo $add; ?>" disabled >
                        <span onclick="ach()" id="aedit" >Edit</span>
                        <br>
                        <div class="btn" id="abtn" >
                            <button id="gsave" name="asave" >Save</button>
                            <button id="acan" onclick="acancel()" >Cancel</button>
                        </div>
                    </form>
                </div>
                
            </div>
            
        </div>
        
        <div class="box2">
            <h1>Bank Details</h1>
            <div class="inputfield">
                <div class="acc">
                    <form action="" method="post" >
                        <label for="acc">Account Number</label>
                        <br>
                        <input type="text" id="acc" name="acc" value="<?php echo $acc; ?>" disabled >
                        <span onclick="accch()" id="accedit" >Edit</span>
                        <br>
                        <div class="btn" id="accbtn" >
                            <button id="accsave" name="accsave" >Save</button>
                            <button id="acccan" onclick="acccancel()" >Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="bnk">
                    <form action="" method="post" >
                        <label for="bnk">Bank</label>
                        
                        <br>
                        <input type="text" id="bnk" name="bnk" value="<?php echo $bnk; ?>" disabled >
                        <span onclick="bnkch()" id="bnkedit" >Edit</span>
                        <br>
                        <div class="btn" id="bnkbtn" >
                            <button id="bnksave" name="bnksave" >Save</button>
                            <button id="bnkcan" onclick="bnkcancel()" >Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="brunch">
                    <form action="" method="post" >
                        <label for="br">Brunch</label>
                        
                        <br>
                        <input type="text" id="br" name="br" value="<?php echo $br; ?>" disabled >
                        <span onclick="brch()" id="bredit" >Edit</span>
                        <br>
                        <div class="btn" id="brbtn" >
                            <button id="brsave" name="brsave" >Save</button>
                            <button id="brcan" onclick="brcancel()" >Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="ifsc">
                    <form action="" method="post" >
                        <label for="ifsc">IFSC</label>
                        
                        <br>
                        <input type="text" id="ifsc" name="ifsc" value="<?php echo $ifsc; ?>" disabled >
                        <span onclick="ich()" id="iedit" >Edit</span>
                        <br>
                        <div class="btn" id="ibtn" >
                            <button id="isave" name="isave" >Save</button>
                            <button id="ican" onclick="icancel()" >Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    <script>
        var ubtn=document.getElementById("ubtn");
        var ebtn=document.getElementById("ebtn");
        var pbtn=document.getElementById("pbtn");
        var user=document.getElementById("user");
        var email=document.getElementById("email");
        var ph=document.getElementById("ph");
        var gen=document.getElementById("gen");
        var gbtn=document.getElementById("gbtn");
        var add=document.getElementById("add");
        var abtn=document.getElementById("abtn");
        var uedit=document.getElementById("uedit");
        var eedit=document.getElementById("eedit");
        var pedit=document.getElementById("pedit");
        var gedit=document.getElementById("gedit");
        var aedit=document.getElementById("aedit");
        var accedit=document.getElementById("accedit");
        var bnkedit=document.getElementById("bnkedit");
        var bredit=document.getElementById("bredit");
        var iedit=document.getElementById("iedit");
        var show=document.getElementById("del");
        var acc=document.getElementById("acc");
        var accbtn=document.getElementById("accbtn");
        var bnk=document.getElementById("bnk");
        var bnkbtn=document.getElementById("bnkbtn");
        var br=document.getElementById("br");
        var brbtn=document.getElementById("brbtn");
        var ifsc=document.getElementById("ifsc");
        var ibtn=document.getElementById("ibtn");

        function uch(){
            ubtn.style.display="block";
            user.disabled=false;
            user.style.backgroundColor="#ececec";
            user.style.textAlign="left";
            user.style.paddingLeft="10px";
        }
        function ucancel(){
            ubtn.style.display="none";
            user.disabled=true;
            user.style.backgroundColor="#dafefb";
            user.style.textAlign="center";
            user.style.paddingLeft="0px"
            
        }

        function ech(){
            ebtn.style.display="block";
            email.disabled=false;
            email.style.backgroundColor="#ececec";
            email.style.textAlign="left";
            email.style.paddingLeft="10px";
        }
        function ecancel(){
            ebtn.style.display="none";
            email.disabled=true;
            email.style.backgroundColor="#dafefb";
            email.style.textAlign="center";
            email.style.paddingLeft="0px"
        }

        function pch(){
            pbtn.style.display="block";
            ph.disabled=false;
            ph.style.backgroundColor="#ececec";
            ph.style.textAlign="left";
            ph.style.paddingLeft="10px";
        }
        function pcancel(){
            pbtn.style.display="none";
            ph.disabled=true;
            ph.style.backgroundColor="#dafefb";
            ph.style.textAlign="center";
            ph.style.paddingLeft="0px";
        }

        function gch(){
            gbtn.style.display="block";
            gen.disabled=false;
            gen.style.backgroundColor="#ececec";
            gen.style.textAlign="left";
            gen.style.paddingLeft="10px";
        }
        function gcancel(){
            gbtn.style.display="none";
            gen.disabled=true;
            gen.style.backgroundColor="#dafefb";
            gen.style.textAlign="center";
            gen.style.paddingLeft="0px";
        }

        function ach(){
            abtn.style.display="block";
            add.disabled=false;
            add.style.backgroundColor="#ececec";
            add.style.textAlign="left";
            add.style.paddingLeft="10px";
        }
        function acancel(){
            abtn.style.display="none";
            add.disabled=true
            add.style.backgroundColor="#dafefb";
            add.style.textAlign="center";
            add.style.paddingLeft="0px";
        }

        function accch(){
            accbtn.style.display="block";
            acc.disabled=false;
            acc.style.backgroundColor="#ececec";
            acc.style.textAlign="left";
            acc.style.paddingLeft="10px";
        }
        function acccancel(){
            accbtn.style.display="none";
            acc.disabled=true;
            acc.style.backgroundColor="#dafefb";
            acc.style.textAlign="center";
            acc.style.paddingLeft="0px";
        }

        function bnkch(){
            bnkbtn.style.display="block";
            bnk.disabled=false;
            bnk.style.backgroundColor="#ececec";
            bnk.style.textAlign="left";
            bnk.style.paddingLeft="10px";
        }
        function bnkcancel(){
            bnkbtn.style.display="none";
            bnk.disabled=true;
            bnk.style.backgroundColor="#dafefb";
            bnk.style.textAlign="center";
            bnk.style.paddingLeft="0px";
        }

        function brch(){
            brbtn.style.display="block";
            br.disabled=false;
            br.style.backgroundColor="#ececec";
            br.style.textAlign="left";
            br.style.paddingLeft="10px";
        }
        function brcancel(){
            brbtn.style.display="none";
            br.disabled=true;
            br.style.backgroundColor="#dafefb";
            br.style.textAlign="center";
            br.style.paddingLeft="0px";
        }

        function ich(){
            ibtn.style.display="block";
            ifsc.disabled=false;
            ifsc.style.backgroundColor="#ececec";
            ifsc.style.textAlign="left";
            ifsc.style.paddingLeft="10px";
        }
        function icancel(){
            ibtn.style.display="none";
            ifsc.disabled=true;
            ifsc.style.backgroundColor="#dafefb";
            ifsc.style.textAlign="center";
            ifsc.style.paddingLeft="0px"
        }
                
        function showpass(){
            if(show.type=="password"){
                show.type="text";
            }
            else{
                show.type="password";
                
            }
        }
    </script>
</body>
</html>